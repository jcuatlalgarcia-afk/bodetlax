<?php

namespace App\Models;

use CodeIgniter\Model;

class OfertaProveedorModel extends Model
{
    protected $table            = 'ofertas_proveedores';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'proveedor_id', 'categoria_id', 'nombre_producto', 'descripcion',
        'unidad_medida', 'precio_ofertado', 'cantidad_ofertada', 'imagen',
        'estado', 'revisado_por',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'categoria_id'      => 'required|integer',
        'nombre_producto'   => 'required|min_length[3]|max_length[150]',
        'unidad_medida'     => 'required|max_length[20]',
        'precio_ofertado'   => 'required|decimal|greater_than[0]',
        'cantidad_ofertada' => 'required|integer|greater_than[0]',
    ];

    public function pendientes()
    {
        return $this->select('ofertas_proveedores.*, usuarios.nombre_completo as proveedor_nombre, categorias.nombre as categoria_nombre')
            ->join('usuarios', 'usuarios.id = ofertas_proveedores.proveedor_id')
            ->join('categorias', 'categorias.id = ofertas_proveedores.categoria_id')
            ->where('ofertas_proveedores.estado', 'pendiente')
            ->orderBy('ofertas_proveedores.created_at', 'ASC');
    }

    public function aceptadasSinPublicar()
    {
        return $this->select('ofertas_proveedores.*, usuarios.nombre_completo as proveedor_nombre, categorias.nombre as categoria_nombre')
            ->join('usuarios', 'usuarios.id = ofertas_proveedores.proveedor_id')
            ->join('categorias', 'categorias.id = ofertas_proveedores.categoria_id')
            ->where('ofertas_proveedores.estado', 'aceptada')
            ->orderBy('ofertas_proveedores.created_at', 'ASC');
    }

    public function conteoePorEstado(int $proveedorId): array
    {
        return $this->select('estado, COUNT(*) as total')
            ->where('proveedor_id', $proveedorId)
            ->groupBy('estado')
            ->findAll();
    }
}