<?php
namespace FacturaScripts\Plugins\SpiderISP;

use FacturaScripts\Core\Base\InitClass;
use FacturaScripts\Plugins\SpiderISP\Model\ConfigInstalacion;


class Init extends InitClass
{
    public function init()
    {
    }
    public function update()
    {
        new ConfigInstalacion();
    }

}
