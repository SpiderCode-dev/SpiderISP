<?php

namespace FacturaScripts\Plugins\SpiderISP\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;

class ListPaymentReminder extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'payment-reminders';
        $data['menu'] = 'customers';
        $data['icon'] = 'fas fa-clock';
        return $data;
    }

    protected function createViews()
    {
        $this->addView('ListPaymentReminder', 'PaymentReminder', 'payment-reminders', 'fas fa-clock');
    }
}