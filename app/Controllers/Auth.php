<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function registro()
    {
        return view('auth/registro');
    }

    public function registroCliente()
    {
        return view('auth/registro_cliente');
    }

    public function intentarRegistroCliente()
    {
        return $this->procesarRegistro('cliente');
    }

    public function registroProveedor()
    {
        return view('auth/registro_proveedor');
    }

    public function intentarRegistroProveedor()
    {
        return $this->procesarRegistro('proveedor');
    }

    public function registroVendedor()
    {
        return view('auth/registro_vendedor');
    }

    public function intentarRegistroVendedor()
    {
        return $this->procesarRegistro('vendedor');
    }

    public function registroRepartidor()
    {
        return view('auth/registro_repartidor');
    }

    public function intentarRegistroRepartidor()
    {
        return $this->procesarRegistro('repartidor');
    }

   private function procesarRegistro(string $nombreRol)
{
    $reglas = [
        'nombre_completo'  => 'required|min_length[3]|max_length[150]',
        'email'            => 'required|valid_email|is_unique[usuarios.email]',
        'telefono'         => 'required|min_length[10]|max_length[20]',
        'password'         => 'required|min_length[8]',
        'password_confirm' => 'required|matches[password]',
    ];

    if (! $this->validate($reglas)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $db  = \Config\Database::connect();
    $rol = $db->table('roles')->where('nombre', $nombreRol)->get()->getRow();

    $requiereAprobacion = in_array($nombreRol, ['vendedor', 'repartidor']);
    $estadoAprobacion   = $requiereAprobacion ? 'pendiente' : 'aprobado';

    $this->usuarioModel->insert([
        'rol_id'            => $rol->id,
        'nombre_completo'   => $this->request->getPost('nombre_completo'),
        'email'             => $this->request->getPost('email'),
        'telefono'          => $this->request->getPost('telefono'),
        'password_hash'     => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        'estado_cuenta'     => 'activo',
        'estado_aprobacion' => $estadoAprobacion,
    ]);

    if ($requiereAprobacion) {
        session()->setFlashdata('success', 'Registro exitoso. Tu cuenta será revisada por un administrador antes de que puedas iniciar sesión.');
    } else {
        session()->setFlashdata('success', 'Registro exitoso. Ya puedes iniciar sesión.');
    }

    return redirect()->to('/login');
}

    public function login()
    {
        return view('auth/login');
    }

    public function intentarLogin()
    {
        $reglas = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $this->usuarioModel->conRol()->where('usuarios.email', $email)->first();

        if (! $usuario || ! password_verify($password, $usuario['password_hash'])) {
            return redirect()->back()->withInput()->with('errors', ['login' => 'Correo o contraseña incorrectos.']);
        }

        if ($usuario['estado_cuenta'] !== 'activo') {
            return redirect()->back()->with('errors', ['login' => 'Tu cuenta está suspendida. Contacta al administrador.']);
        }

        if (in_array($usuario['rol_nombre'], ['vendedor', 'repartidor']) && $usuario['estado_aprobacion'] !== 'aprobado') {
            $mensaje = $usuario['estado_aprobacion'] === 'pendiente'
                ? 'Tu cuenta todavía está pendiente de aprobación por un administrador.'
                : 'Tu solicitud fue rechazada. Contacta al administrador.';

            return redirect()->back()->with('errors', ['login' => $mensaje]);
        }

        session()->set([
            'usuario_id'      => $usuario['id'],
            'nombre_completo' => $usuario['nombre_completo'],
            'rol'             => $usuario['rol_nombre'],
            'isLoggedIn'      => true,
        ]);

        return $this->redirigirPorRol($usuario['rol_nombre']);
    }

    private function redirigirPorRol(string $rol)
    {
        return match ($rol) {
            'administrador' => redirect()->to('/admin/dashboard'),
            'vendedor'      => redirect()->to('/vendedor/dashboard'),
            'proveedor'     => redirect()->to('/proveedor/dashboard'),
            'repartidor'    => redirect()->to('/repartidor/dashboard'),
            default         => redirect()->to('/catalogo'),
        };
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}