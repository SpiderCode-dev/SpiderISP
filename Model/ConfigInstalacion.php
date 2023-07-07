<?php

namespace FacturaScripts\Plugins\SpiderISP\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

class ConfigInstalacion extends ModelClass
{
    use ModelTrait;

    public static function primaryColumn(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'isp_config_instalacion';
    }
}