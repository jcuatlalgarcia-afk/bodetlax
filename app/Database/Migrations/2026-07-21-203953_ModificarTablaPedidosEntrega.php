<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModificarTablaPedidosEntrega extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE pedidos MODIFY estado ENUM('pendiente','en_camino','pagado','completo','cancelado') DEFAULT 'pendiente'");
        $this->db->query("ALTER TABLE historial_estado_pedido MODIFY estado ENUM('pendiente','en_camino','pagado','completo','cancelado')");

        $this->forge->addColumn('pedidos', [
            'evidencia_entrega' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'entregado_por'     => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'fecha_entrega'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->db->query("ALTER TABLE pedidos ADD CONSTRAINT fk_pedidos_entregado_por FOREIGN KEY (entregado_por) REFERENCES usuarios(id) ON DELETE SET NULL");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE pedidos DROP FOREIGN KEY fk_pedidos_entregado_por");
        $this->forge->dropColumn('pedidos', ['evidencia_entrega', 'entregado_por', 'fecha_entrega']);
        $this->db->query("ALTER TABLE pedidos MODIFY estado ENUM('pendiente','en_camino','entregado','cancelado') DEFAULT 'pendiente'");
        $this->db->query("ALTER TABLE historial_estado_pedido MODIFY estado ENUM('pendiente','en_camino','entregado','cancelado')");
    }
}