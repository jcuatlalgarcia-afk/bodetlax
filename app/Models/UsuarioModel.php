<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'rol_id',
        'nombre_completo',
        'email',
        'password_hash',
        'telefono',
        'direccion',
        'metodo_pago_preferido',
        'email_verificado_en',
        'reset_token',
        'reset_token_expira_en',
        'estado_cuenta',
        'estado_aprobacion',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nombre_completo' => 'required|min_length[3]|max_length[150]',
        'email'           => 'required|valid_email|is_unique[usuarios.email,id,{id}]',
        'rol_id'          => 'required|integer',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Este correo ya está registrado.',
        ],
    ];

    // Trae usuarios con su nombre de rol ya unido (útil en varios lugares)
    public function conRol()
    {
        return $this->select('usuarios.*, roles.nombre as rol_nombre')
            ->join('roles', 'roles.id = usuarios.rol_id');
    }
}
