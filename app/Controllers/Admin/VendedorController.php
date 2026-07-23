<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Libraries\Notificador;

class PersonalController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    // $rol = 'vendedor' o 'repartidor'
    public function pendientes($rol)
    {
        $this->validarRol($rol);

        $db = \Config\Database::connect();
        $personal = $db->table('usuarios')
            ->select('usuarios.*, roles.nombre as rol_nombre')
            ->join('roles', 'roles.id = usuarios.rol_id')
            ->where('roles.nombre', $rol)
            ->where('usuarios.estado_aprobacion', 'pendiente')
            ->orderBy('usuarios.created_at', 'ASC')
            ->get()->getResultArray();

        return view('admin/personal/pendientes', ['personal' => $personal, 'rol' => $rol]);
    }

    public function index($rol)
    {
        $this->validarRol($rol);

        $db = \Config\Database::connect();
        $personal = $db->table('usuarios')
            ->select('usuarios.*, roles.nombre as rol_nombre')
            ->join('roles', 'roles.id = usuarios.rol_id')
            ->where('roles.nombre', $rol)
            ->where('usuarios.estado_aprobacion', 'aprobado')
            ->orderBy('usuarios.nombre_completo', 'ASC')
            ->get()->getResultArray();

        return view('admin/personal/index', ['personal' => $personal, 'rol' => $rol]);
    }

    public function aprobar($rol, $id)
    {
        $this->validarRol($rol);
        $persona = $this->usuarioModel->find($id);

        $this->usuarioModel->update($id, ['estado_aprobacion' => 'aprobado']);
        (new Notificador())->vendedorAprobado($persona['email'], $persona['nombre_completo']);

        session()->setFlashdata('success', 'Cuenta aprobada y notificada.');
        return redirect()->to("/admin/personal/{$rol}/pendientes");
    }

    public function rechazar($rol, $id)
    {
        $this->validarRol($rol);
        $persona = $this->usuarioModel->find($id);

        $this->usuarioModel->update($id, ['estado_aprobacion' => 'rechazado']);
        (new Notificador())->vendedorRechazado($persona['email'], $persona['nombre_completo']);

        session()->setFlashdata('success', 'Solicitud rechazada y notificada.');
        return redirect()->to("/admin/personal/{$rol}/pendientes");
    }

    public function desactivar($rol, $id)
    {
        $this->validarRol($rol);
        $this->usuarioModel->update($id, ['estado_cuenta' => 'suspendido']);
        session()->setFlashdata('success', 'Cuenta desactivada.');
        return redirect()->to("/admin/personal/{$rol}");
    }

    public function reactivar($rol, $id)
    {
        $this->validarRol($rol);
        $this->usuarioModel->update($id, ['estado_cuenta' => 'activo']);
        session()->setFlashdata('success', 'Cuenta reactivada.');
        return redirect()->to("/admin/personal/{$rol}");
    }

    public function eliminar($rol, $id)
    {
        $this->validarRol($rol);
        $this->usuarioModel->delete($id);
        session()->setFlashdata('success', 'Cuenta eliminada del sistema.');
        return redirect()->to("/admin/personal/{$rol}");
    }

    // Seguridad extra: nunca dejar operar este controlador con un rol distinto a estos dos
    private function validarRol(string $rol): void
    {
        if (! in_array($rol, ['vendedor', 'repartidor'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}