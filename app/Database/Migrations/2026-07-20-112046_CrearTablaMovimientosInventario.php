<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaMovimientosInventario extends Migration
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
            'tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['entrada', 'salida'],
            ],
            'cantidad' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'motivo' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'creado_por' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('creado_por', 'usuarios', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('movimientos_inventario');
    }

    public function down()
    {
        $this->forge->dropTable('movimientos_inventario');
    }
}
