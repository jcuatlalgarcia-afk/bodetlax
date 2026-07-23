<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoItemModel extends Model
{
    protected $table            = 'pedido_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'pedido_id', 'producto_id', 'nombre_producto', 'precio_unitario', 'cantidad', 'total_linea',
    ];

    protected $useTimestamps = false;

    // Ventas totales por día, últimos N días (todo el negocio, ya no por vendedor individual)
public function ventasPorDia(int $dias = 7): array
{
    return $this->select("DATE(pedidos.created_at) as fecha, SUM(pedido_items.total_linea) as total")
        ->join('pedidos', 'pedidos.id = pedido_items.pedido_id')
        ->where('pedidos.estado !=', 'cancelado')
        ->where('pedidos.created_at >=', date('Y-m-d', strtotime("-{$dias} days")))
        ->groupBy('DATE(pedidos.created_at)')
        ->orderBy('fecha', 'ASC')
        ->findAll();
}

// Top productos más vendidos (todo el negocio)
public function masVendidos(int $limite = 5): array
{
    return $this->select("pedido_items.nombre_producto, SUM(pedido_items.cantidad) as total_vendido")
        ->join('pedidos', 'pedidos.id = pedido_items.pedido_id')
        ->where('pedidos.estado !=', 'cancelado')
        ->groupBy('pedido_items.producto_id, pedido_items.nombre_producto')
        ->orderBy('total_vendido', 'DESC')
        ->limit($limite)
        ->findAll();
}
}