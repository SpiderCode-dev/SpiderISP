<?php

namespace FacturaScripts\Plugins\SpiderISP\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

class PaymentReminder extends ModelClass
{
    use ModelTrait;

    public $id;
    public $idcontacto;
    public $idplan;
    public $total;
    public $date;
    public $hour;


    public static function primaryColumn(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'isp_payments_reminders';
    }
}