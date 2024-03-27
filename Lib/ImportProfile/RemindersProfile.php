<?php

namespace FacturaScripts\Plugins\SpiderISP\Lib\ImportProfile;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Model\Contacto;
use FacturaScripts\Plugins\CSVimport\Lib\ImportProfile\ProfileClass;
use FacturaScripts\Plugins\SpiderISP\Model\PaymentRequest;

/**
 * Description of Reminders
 *
 */
class RemindersProfile extends ProfileClass
{

    /**
     * 
     * @return array
     */
    public function getDataFields(): array
    {
        return [
            'contactos.nombre' => ['title' => 'name'],
            'contactos.telefono1' => ['title' => 'phone'],
            'planes.name' => ['title' => 'plan'],
            'isp_payments_reminders.total' => ['title' => 'total'],
            'isp_payments_reminders.date' => ['title' => 'date'],
        ];
    }

    /**
     * 
     * @param array $item
     *
     * @return bool
     */
    protected function importItem(array $item): bool
    {
        if (empty($item['contactos.telefono1']) ||
            empty($item['contactos.nombre']) ||
            empty($item['planes.name']) ||
            empty($item['isp_payments_reminders.total']) ||
            empty($item['isp_payments_reminders.date'])){
            Tools::log()->warning('Debes seleccionar todos los campos');
            return false;
        }

        $contact = new Contacto();
        $where = [new DataBaseWhere('telefono1', $item['contactos.telefono1'])];
        $contact->loadFromCode('', $where);
        $contact->nombre = $item['contactos.nombre'];
        $contact->telefono1 = $item['contactos.telefono1'];
        $contact->cifnif = $item['contactos.cifnif'] ?? '';

        if (!$contact->save()) {
            return false;
        }

        $reminder = new PaymentRequest();
        $where = [
            new DataBaseWhere('idcontacto', $contact->idcontacto),
            new DataBaseWhere('plan', $item['planes.name']),
        ];

        $reminder->loadFromCode('', $where);
        $reminder->idcontacto = $contact->idcontacto;
        $reminder->plan = $item['planes.name'];
        $reminder->total = $item['isp_payments_reminders.total'];
        $reminder->date = $item['isp_payments_reminders.date'];

        return $reminder->save();
    }
}
