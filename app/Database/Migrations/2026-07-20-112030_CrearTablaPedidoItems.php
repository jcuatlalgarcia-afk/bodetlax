<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaPedidoItems extends Migration
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
            'pedido_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'producto_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'nombre_producto' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'precio_unitario' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'cantidad' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'total_linea' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pedido_id', 'pedidos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('pedido_items');
    }

    public function down()
    {
        $this->forge->dropTable('pedido_items');
    }
}
