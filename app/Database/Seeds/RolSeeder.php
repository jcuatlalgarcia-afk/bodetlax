<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre' => 'administrador', 'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'vendedor',      'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'proveedor',     'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'cliente',       'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
