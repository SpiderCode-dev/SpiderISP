<?php
/**
 * Copyright (C) 2019-2020 Carlos Garcia Gomez <carlos@facturascripts.com>
 */
namespace FacturaScripts\Plugins\SpiderISP\Lib\Import;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Dinamic\Model\Familia;
use FacturaScripts\Plugins\CSVimport\Lib\Import\CsvImporClass;

/**
 * Description of FamilyImport
 *
 * @author Carlos Garcia Gomez <carlos@facturascripts.com>
 */
class ReminderImport extends CsvImporClass
{
    /**
     * 
     * @return string
     */
    protected static function getProfile()
    {
        return 'payment-request';
    }

    /**
     * @param string $filePath
     * @return mixed
     */
    protected static function getFileType(string $filePath)
    {
        // TODO: Implement getFileType() method.
    }

    /**
     * @param $type
     * @param $filePath
     * @param $mode
     * @return mixed
     */
    protected static function importType($type, $filePath, $mode)
    {
        // TODO: Implement importType() method.
    }
}
