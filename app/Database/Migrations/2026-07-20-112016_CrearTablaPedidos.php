<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaPedidos extends Migration
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
            'cliente_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'impuesto' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'costo_envio' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['pendiente', 'en_camino', 'entregado', 'cancelado'],
                'default'    => 'pendiente',
            ],
            'direccion_envio' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'metodo_pago' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('estado');
        $this->forge->addForeignKey('cliente_id', 'usuarios', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('pedidos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos');
    }
}