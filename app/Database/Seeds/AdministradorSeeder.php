<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdministradorSeeder extends Seeder
{
    public function run()
    {
        $rolAdmin = $this->db->table('roles')->where('nombre', 'administrador')->get()->getRow();

        $this->db->table('usuarios')->insert([
            'rol_id'            => $rolAdmin->id,
            'nombre_completo'   => 'Administrador BodeTlax',
            'email'             => 'jcuatlalgarcia@gmail.com',
            'password_hash'     => password_hash('12345678', PASSWORD_BCRYPT),
            'estado_cuenta'     => 'activo',
            'estado_aprobacion' => 'aprobado',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);
    }
}
