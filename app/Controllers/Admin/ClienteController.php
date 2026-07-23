<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ClienteController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $clientes = $db->table('usuarios')
            ->select('usuarios.id, usuarios.nombre_completo, usuarios.email, usuarios.telefono, usuarios.direccion, usuarios.estado_cuenta, usuarios.created_at')
            ->join('roles', 'roles.id = usuarios.rol_id')
            ->where('roles.nombre', 'cliente')
            ->orderBy('usuarios.nombre_completo', 'ASC')
            ->get()->getResultArray();

        return view('admin/clientes/index', ['clientes' => $clientes]);
    }
}