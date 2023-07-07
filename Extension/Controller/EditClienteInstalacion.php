<?php

namespace FacturaScripts\Plugins\SpiderISP\Extension\Controller;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

class EditClienteInstalacion
{
    public function createViews() {
        return function() {
            $this->addEditView('EditConfigInstalacion', 'ConfigInstalacion', 'Mikrotik', 'fas fa-cogs');
        };
    }

    public function loadData(){
        return function($viewName, $view) {
            if ($viewName == 'EditConfigInstalacion') {
                $code = $this->request->query->get('code');
                $view->loadData('', [
                    new DataBaseWhere('id_installation', $code)
                ]);
                $view->model->id_installation = $code;
            }
        };
    }
}