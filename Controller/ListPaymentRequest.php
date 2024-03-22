<?php

namespace FacturaScripts\Plugins\SpiderISP\Controller;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Lib\ExtendedController\ListController;
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\SpiderISP\Lib\Import\ReminderImport;
use FacturaScripts\Plugins\SpiderISP\Model\PaymentRequest;

class ListPaymentRequest extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'payment-request';
        $data['menu'] = 'whatsapp';
        $data['icon'] = 'fas fa-money-check-alt';
        return $data;
    }

    protected function createViews()
    {
        $viewName = 'ListPaymentRequest';
        $this->addView($viewName, 'PaymentRequest', 'payment-request', 'fas fa-money-check-alt');
        $newButton = [
            'action' => 'download-csv',
            'color' => 'info',
            'icon' => 'fas fa-download',
            'label' => 'Plantilla',
        ];
        $this->addButton($viewName, $newButton);

        $newButton = [
            'action' => 'import-reminders',
            'color' => 'warning',
            'icon' => 'fas fa-file-import',
            'label' => 'import-reminders',
            'type' => 'modal'
        ];
        $this->addButton($viewName, $newButton);

        $newButton = [
            'action' => 'send-messages',
            'color' => 'success',
            'icon' => 'fab fa-whatsapp',
            'label' => 'send-messages',
            'type' => 'confirm'
        ];
        $this->addButton($viewName, $newButton);
    }

    public function execPreviousAction($action)
    {
        switch ($action) {
            case 'send-messages':
                $requests = (new PaymentRequest())->all();
                foreach ($requests as $reminder) {
                    $reminder->sendMessage();
                }
                break;
            case 'import-reminders':
                return $this->importRequestPayments();
            case 'download-csv':
                return $this->downloadTemplate();
        }
        parent::execPreviousAction($action);
    }

    public function downloadTemplate()
    {
        $this->setTemplate(false);
        $filePath = FS_FOLDER . '/Plugins/SpiderISP/Template/template_request.csv';
        $this->response->headers->set('Content-Type', 'text/csv');
        $this->response->headers->set('Content-Disposition', 'attachment; filename="template_request.csv"');
        $this->response->setContent(file_get_contents($filePath));
        return false;
    }

    public function importRequestPayments()
    {
        $uploadFile = $this->request->files->get('remindersfile');
        if (!ReminderImport::isValidFile($uploadFile)) {
            Tools::log()->error('file-not-supported');
            Tools::log()->error($uploadFile->getMimeType());
            return true;
        }

        $where = [];
        if (!$this->user->admin)
            $where[] = [new DataBaseWhere('nick', $this->user->nick)];

        $requests = (new PaymentRequest())->all($where, [], 0, 0);
        foreach ($requests as $request) {
            $request->delete();
        }
        $newCsvFile = ReminderImport::advancedImport($uploadFile);
        $this->redirect($newCsvFile->url());
        return true;
    }
}