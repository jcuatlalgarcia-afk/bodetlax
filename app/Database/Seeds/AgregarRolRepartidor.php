<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AgregarRolRepartidor extends Seeder
{
    public function run()
    {
        $existe = $this->db->table('roles')->where('nombre', 'repartidor')->countAllResults();

        if ($existe === 0) {
            $this->db->table('roles')->insert(['nombre' => 'repartidor', 'created_at' => date('Y-m-d H:i:s')]);
        }
    }
}