<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaPromociones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'producto_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'porcentaje_descuento' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'inicia_en' => [
                'type' => 'DATETIME',
            ],
            'termina_en' => [
                'type' => 'DATETIME',
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('promociones');
    }

    public function down()
    {
        $this->forge->dropTable('promociones');
    }
}
