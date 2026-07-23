<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\ProductoModel;
use App\Models\PedidoModel;
use App\Models\OfertaProveedorModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $usuarioModel = new UsuarioModel();
        $productoModel = new ProductoModel();
        $pedidoModel = new PedidoModel();
        $ofertaModel = new OfertaProveedorModel();

        $db = \Config\Database::connect();

        $data = [
            'totalClientes'        => $db->table('usuarios')->join('roles', 'roles.id = usuarios.rol_id')->where('roles.nombre', 'cliente')->countAllResults(),
            'totalProveedores'     => $db->table('usuarios')->join('roles', 'roles.id = usuarios.rol_id')->where('roles.nombre', 'proveedor')->countAllResults(),
            'vendedoresPendientes' => $usuarioModel->join('roles', 'roles.id = usuarios.rol_id')->where('roles.nombre', 'vendedor')->where('estado_aprobacion', 'pendiente')->countAllResults(),
            'ofertasPendientes'    => $ofertaModel->where('estado', 'pendiente')->countAllResults(),
            'totalPedidos'         => $pedidoModel->countAllResults(),
            'totalProductosActivos' => $productoModel->where('estado', 'activo')->countAllResults(),
        ];

        return view('admin/dashboard/index', $data);
    }

    public function datosUsuarios()
    {
        $db = \Config\Database::connect();
        $filas = $db->table('roles')
            ->select('roles.nombre, COUNT(usuarios.id) as total')
            ->join('usuarios', 'usuarios.rol_id = roles.id', 'left')
            ->where('usuarios.estado_cuenta', 'activo')
            ->groupBy('roles.id')
            ->get()->getResultArray();

        return $this->response->setJSON([
            'labels' => array_map('ucfirst', array_column($filas, 'nombre')),
            'values' => array_map('intval', array_column($filas, 'total')),
        ]);
    }
}
