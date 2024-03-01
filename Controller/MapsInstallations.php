<?php

namespace FacturaScripts\Plugins\SpiderISP\Controller;

use FacturaScripts\Core\Lib\ExtendedController\PanelController;
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
    }

    protected function loadData($viewName, $view)
    {
        // TODO: Implement loadData() method.
    }

    public function getZones()
    {
        return (new Zona())->all();
    }
}