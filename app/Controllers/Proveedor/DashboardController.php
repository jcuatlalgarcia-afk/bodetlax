<?php

namespace App\Controllers\Proveedor;

use App\Controllers\BaseController;
use App\Models\OfertaProveedorModel;

class DashboardController extends BaseController
{
    protected $ofertaModel;

    public function __construct()
    {
        $this->ofertaModel = new OfertaProveedorModel();
    }

    public function index()
    {
        $proveedorId = session()->get('usuario_id');

        $totalOfertas = $this->ofertaModel->where('proveedor_id', $proveedorId)->countAllResults();
        $pendientes   = $this->ofertaModel->where('proveedor_id', $proveedorId)->where('estado', 'pendiente')->countAllResults();
        $aceptadas    = $this->ofertaModel->where('proveedor_id', $proveedorId)->whereIn('estado', ['aceptada', 'publicada'])->countAllResults();

        return view('proveedor/dashboard/index', [
            'totalOfertas' => $totalOfertas,
            'pendientes'   => $pendientes,
            'aceptadas'    => $aceptadas,
        ]);
    }

    public function datosEstados()
    {
        $datos = $this->ofertaModel->conteoePorEstado(session()->get('usuario_id'));

        return $this->response->setJSON([
            'labels' => array_map('ucfirst', array_column($datos, 'estado')),
            'values' => array_map('intval', array_column($datos, 'total')),
        ]);
    }
}
