<?php
namespace FacturaScripts\Plugins\SpiderISP;

use FacturaScripts\Core\Base\InitClass;
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\SpiderISP\Model\ConfigInstalacion;
use FacturaScripts\Plugins\SpiderISP\Model\PaymentReminder;


class Init extends InitClass
{
    public function init()
    {

    }
    public function update()
    {
        if (Tools::settings('reminders', 'message') === null) {
            Tools::settingsSet('reminders', 'message', 'Recuerda que tienes una factura pendiente de pago.');
        }
        if (Tools::settings('reminders', 'hour') === null) {
            Tools::settingsSet('reminders', 'hour', '12:00');
        }
        Tools::settingsSave();

        new ConfigInstalacion();
        new PaymentReminder();
    }

}
