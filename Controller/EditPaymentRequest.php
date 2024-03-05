<?php

namespace FacturaScripts\Plugins\SpiderISP\Controller;

use FacturaScripts\Core\Lib\ExtendedController\EditController;

class EditPaymentRequest extends EditController
{

    /**
     * @return string
     */
    public function getModelClassName(): string
    {
        return 'PaymentRequest';
    }
}