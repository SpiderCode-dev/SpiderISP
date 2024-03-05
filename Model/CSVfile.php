<?php

namespace FacturaScripts\Plugins\SpiderISP\Model;

class CSVfile extends \FacturaScripts\Plugins\CSVimport\Model\CSVfile
{
    protected function getProfileClass()
    {
        if ($this->profile == 'payment-request') {
            return '\FacturaScripts\Plugins\SpiderISP\Lib\ImportProfile\RemindersProfile';
        }

        return parent::getProfileClass();
    }
}
