<?php

namespace FacturaScripts\Plugins\SpiderFinance\Model;

class ispCliente extends \FacturaScripts\Core\Model\Base\JoinModel
{
    protected function getFields(): array
    {
        return [
            'concepto' => 'partidas.concepto',
            'debe' => 'partidas.debe',
            'fecha' => 'asientos.fecha',
            'haber' => 'partidas.haber',
            'idasiento' => 'partidas.idasiento',
            'idpartida' => 'partidas.idpartida',
            'numero' => 'asientos.numero'
        ];
    }

    protected function getSQLFrom(): string
    {
        return 'sfi_cliente_instalaciones LEFT JOIN clientes ON sfi_cliente_instalaciones.codcliente = clientes.codcliente';
    }

    protected function getTables(): array
    {
        return ['sfi_cliente_instalaciones', 'clientes'];
    }
}