<?php

namespace FacturaScripts\Plugins\SpiderISP\Lib\ImportProfile;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Dinamic\Model\Contacto;
use FacturaScripts\Dinamic\Model\Plan;
use FacturaScripts\Plugins\CSVimport\Lib\ImportProfile\ProfileClass;
use FacturaScripts\Plugins\SpiderCompucima\Model\Almacen;
use FacturaScripts\Plugins\SpiderISP\Model\PaymentReminder;

/**
 * Description of Reminders
 *
 */
class RemindersProfile extends ProfileClass
{

    /**
     * 
     * @return array
     */
    public function getDataFields(): array
    {
        return [
            'contactos.nombre' => ['title' => 'name'],
            'contactos.telefono1' => ['title' => 'phone'],
            'contactos.cifnif' => ['title' => 'cifnif'],
            'planes.name' => ['title' => 'plan'],
            'isp_payments_reminders.total' => ['title' => 'total'],
            'isp_payments_reminders.date' => ['title' => 'date'],
        ];
    }

    /**
     * 
     * @param array $item
     *
     * @return bool
     */
    protected function importItem(array $item): bool
    {
        if (empty($item['contactos.telefono1']) || empty($item['contactos.nombre'])) {
            return false;
        }

        $contact = new Contacto();
        $where = [new DataBaseWhere('telefono1', $item['contactos.telefono1'])];
        $contact->loadFromCode('', $where);
        $contact->nombre = $item['contactos.nombre'];
        $contact->telefono1 = $item['contactos.telefono1'];
        $contact->cifnif = $item['contactos.cifnif'];

        if (!$contact->save()) {
            return false;
        }

        $plan = new Plan();
        $where = [new DataBaseWhere('name', $item['planes.name'])];
        $plan->loadFromCode('', $where);
        $plan->name = $item['planes.name'];
        $plan->price = $item['isp_payments_reminders.total'];

        if (!$plan->save()) {
            return false;
        }

        $reminder = new PaymentReminder();
        $where = [
            new DataBaseWhere('idcontacto', $contact->idcontacto),
            new DataBaseWhere('idplan', $plan->id),
        ];

        $reminder->loadFromCode('', $where);
        $reminder->idcontacto = $contact->idcontacto;
        $reminder->idplan = $plan->id;
        $reminder->total = $item['isp_payments_reminders.total'];
        $reminder->date = $item['isp_payments_reminders.date'];

        return $reminder->save();
    }
}
