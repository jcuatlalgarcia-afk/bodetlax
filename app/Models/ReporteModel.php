<?php

namespace App\Models;

use CodeIgniter\Model;

class ReporteModel extends Model
{
    protected $table            = 'reportes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = ['producto_id', 'reportado_por', 'motivo', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function conDetalles()
    {
        return $this->select('reportes.id, reportes.motivo, reportes.estado, reportes.created_at,
                               productos.nombre as producto_nombre, productos.id as producto_id,
                               usuarios.nombre_completo as reportante_nombre')
            ->join('productos', 'productos.id = reportes.producto_id')
            ->join('usuarios', 'usuarios.id = reportes.reportado_por')
            ->orderBy('reportes.created_at', 'DESC');
    }
}