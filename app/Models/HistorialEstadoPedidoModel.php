<?php

namespace App\Models;

use CodeIgniter\Model;

class HistorialEstadoPedidoModel extends Model
{
    protected $table            = 'historial_estado_pedido';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = ['pedido_id', 'estado', 'cambiado_por'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}