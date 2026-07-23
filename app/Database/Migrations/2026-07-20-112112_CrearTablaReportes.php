<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaReportes extends Migration
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
            'reportado_por' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'motivo' => [
                'type' => 'TEXT',
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['pendiente', 'revisado'],
                'default'    => 'pendiente',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reportado_por', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reportes');
    }

    public function down()
    {
        $this->forge->dropTable('reportes');
    }
}
