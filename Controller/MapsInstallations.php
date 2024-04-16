<?php

namespace FacturaScripts\Plugins\SpiderISP\Controller;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Lib\ExtendedController\PanelController;
use FacturaScripts\Dinamic\Lib\AssetManager;
use FacturaScripts\Dinamic\Model\CajaNap;
use FacturaScripts\Plugins\SpiderFinance\Model\Zona;

class MapsInstallations extends PanelController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['menu'] = 'customers';
        $data['title'] = 'maps';
        $data['icon'] = 'fas fa-map-marked-alt';
        return $data;
    }

    protected function createViews()
    {
        $this->addHtmlView('MapsInstallations', 'MapsInstallations', 'ClienteInstalacion', 'fas fa-map-marked-alt');
        AssetManager::addCss(FS_ROUTE . '/node_modules/jquery-ui-dist/jquery-ui.min.css', 2);
        AssetManager::addJs(FS_ROUTE . '/node_modules/jquery-ui-dist/jquery-ui.min.js', 2);
        AssetManager::addJs(FS_ROUTE . '/Dinamic/Assets/JS/WidgetAutocomplete.js');
    }

    protected function loadData($viewName, $view)
    {
        // TODO: Implement loadData() method.
    }

    public function execPreviousAction($action)
    {
        switch ($action) {
            case 'get-clients-location':
                $this->getClientsLocation();
                break;
            case 'get-naps-location':
                $this->getNapsLocation();
                break;
            default:
                break;
        }
        parent::execPreviousAction($action);
    }

    public function getNapsLocation(){
        $this->setTemplate(false);
        $nap = new CajaNap ();
        $where = [];
        $data = $this->request->request->all();
        
        $idcaja = $data["idcajan"];
        if(!empty($idcaja) and !empty($data["textcajanap"])){
            $where[] = new DataBaseWhere('id',$idcaja);
        }

        $result = $nap->all($where);
        $this->response->setContent(json_encode($result));
    }

    public function getZones()
    {
        return (new Zona())->all();
    }
}