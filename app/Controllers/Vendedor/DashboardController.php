<?php

namespace App\Controllers\Vendedor;

use App\Controllers\BaseController;
use App\Models\PedidoItemModel;
use App\Models\ProductoModel;
use App\Models\OfertaProveedorModel;

class DashboardController extends BaseController
{
    protected $pedidoItemModel;
    protected $productoModel;
    protected $ofertaModel;

    public function __construct()
    {
        $this->pedidoItemModel = new PedidoItemModel();
        $this->productoModel   = new ProductoModel();
        $this->ofertaModel     = new OfertaProveedorModel();
    }

    public function index()
    {
        $totalProductos = $this->productoModel->where('estado', 'activo')->countAllResults();
        $ofertasPorPublicar = $this->ofertaModel->where('estado', 'aceptada')->countAllResults();

        return view('vendedor/dashboard/index', [
            'totalProductos'     => $totalProductos,
            'ofertasPorPublicar' => $ofertasPorPublicar,
        ]);
    }

    public function datosVentas()
    {
        $datos = $this->pedidoItemModel->ventasPorDia(7);

        return $this->response->setJSON([
            'labels' => array_column($datos, 'fecha'),
            'values' => array_map('floatval', array_column($datos, 'total')),
        ]);
    }

    public function datosMasVendidos()
    {
        $datos = $this->pedidoItemModel->masVendidos(5);

        return $this->response->setJSON([
            'labels' => array_column($datos, 'nombre_producto'),
            'values' => array_map('intval', array_column($datos, 'total_vendido')),
        ]);
    }
}
