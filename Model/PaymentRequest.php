<?php

namespace FacturaScripts\Plugins\SpiderISP\Model;

use FacturaScripts\Core\Base\ToolBox;
use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;
use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Model\Contacto;
use FacturaScripts\Plugins\SpiderWhatsApp\Lib\SWApi;
use FacturaScripts\Plugins\SpiderWhatsApp\Lib\SWNotificationInterface;

class PaymentRequest extends ModelClass implements SWNotificationInterface
{
    use ModelTrait;

    public $id;
    public $idcontacto;
    public $plan;
    public $total;
    public $date;


    public static function primaryColumn(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'isp_payments_requests';
    }

    /**
     * @return mixed
     */
    public function sendMessage()
    {
        $contact = $this->getContact();
        $message = Tools::settings('reminders', 'message');
        $message = str_replace('{NOMBRE}', $contact->nombre, $message);
        $message = str_replace('{PRECIO}', $this->total, $message);
        $message = str_replace('{PLAN}', $this->plan, $message);

        $api = SWApi::getInstance();
        $result = $api->sendText($contact->telefono1, $message);
        if ($result) {
            ToolBox::log()->notice('Se ha enviado mensaje programado a ' . $contact->telefono1);
        }
    }

    public function getContact()
    {
        return (new Contacto())->get($this->idcontacto);
    }
}
