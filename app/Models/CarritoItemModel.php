<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoItemModel extends Model
{
    protected $table            = 'carrito_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = ['usuario_id', 'producto_id', 'cantidad'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function conProductos(int $usuarioId)
    {
        return $this->select('carrito_items.id, carrito_items.cantidad, productos.id as producto_id,
                               productos.nombre, productos.precio, productos.precio_descuento,
                               productos.stock, productos.imagen_principal, productos.unidad_medida')
            ->join('productos', 'productos.id = carrito_items.producto_id')
            ->where('carrito_items.usuario_id', $usuarioId)
            ->findAll();
    }
}