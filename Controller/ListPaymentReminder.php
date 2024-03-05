<?php

namespace FacturaScripts\Plugins\SpiderISP\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\SpiderISP\Lib\Import\ReminderImport;

class ListPaymentReminder extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'payment-reminders';
        $data['menu'] = 'whatsapp';
        $data['icon'] = 'fas fa-money-check-alt';
        return $data;
    }

    protected function createViews()
    {
        $this->addView('ListPaymentReminder', 'PaymentReminder', 'payment-reminders', 'fas fa-money-check-alt');
        $newButton = [
            'action' => 'import-reminders',
            'color' => 'warning',
            'icon' => 'fas fa-file-import',
            'label' => 'import-reminders',
            'type' => 'modal'
        ];
        $this->addButton('ListPaymentReminder', $newButton);

        $this->addEditView();
    }

    public function execPreviousAction($action)
    {
        if ($action === 'import-reminders') {
            return $this->importReminders();
        }
        parent::execPreviousAction($action);
    }

    public function importReminders()
    {
        $uploadFile = $this->request->files->get('remindersfile');
        if (!ReminderImport::isValidFile($uploadFile)) {
            Tools::log()->error('file-not-supported');
            Tools::log()->error($uploadFile->getMimeType());
            return true;
        }

        $newCsvFile = ReminderImport::advancedImport($uploadFile);
        $this->redirect($newCsvFile->url());
        return true;
    }
}