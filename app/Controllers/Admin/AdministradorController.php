<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class AdministradorController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $administradores = $db->table('usuarios')
            ->select('usuarios.id, usuarios.nombre_completo, usuarios.email, usuarios.estado_cuenta')
            ->join('roles', 'roles.id = usuarios.rol_id')
            ->where('roles.nombre', 'administrador')
            ->get()->getResultArray();

        return view('admin/administradores/index', ['administradores' => $administradores]);
    }

    public function crear()
    {
        return view('admin/administradores/crear');
    }

    public function guardar()
    {
        $reglas = [
            'nombre_completo'  => 'required|min_length[3]|max_length[150]',
            'email'            => 'required|valid_email|is_unique[usuarios.email]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $rolAdmin = $db->table('roles')->where('nombre', 'administrador')->get()->getRow();

        $this->usuarioModel->insert([
            'rol_id'            => $rolAdmin->id,
            'nombre_completo'   => $this->request->getPost('nombre_completo'),
            'email'             => $this->request->getPost('email'),
            'password_hash'     => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'estado_cuenta'     => 'activo',
            'estado_aprobacion' => 'aprobado',
        ]);

        session()->setFlashdata('success', 'Nuevo administrador creado.');
        return redirect()->to('/admin/administradores');
    }
}
