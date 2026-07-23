<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaHistorialEstadoPedido extends Migration
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
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['pendiente', 'en_camino', 'entregado', 'cancelado'],
            ],
            'cambiado_por' => [
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
        $this->forge->addForeignKey('pedido_id', 'pedidos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('cambiado_por', 'usuarios', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('historial_estado_pedido');
    }

    public function down()
    {
        $this->forge->dropTable('historial_estado_pedido');
    }
}
