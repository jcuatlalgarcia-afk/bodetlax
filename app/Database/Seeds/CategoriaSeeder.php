<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre' => 'Cemento y concreto', 'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Varilla y acero',     'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Tabique y block',      'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Pintura',              'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Herramientas',         'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Plomería',             'created_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Electricidad',         'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('categorias')->insertBatch($data);
    }
}
