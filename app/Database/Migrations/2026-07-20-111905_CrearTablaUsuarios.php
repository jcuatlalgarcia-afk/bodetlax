<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaUsuarios extends Migration
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
            'rol_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'nombre_completo' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'unique'     => true,
            ],
            'password_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'telefono' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'direccion' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'metodo_pago_preferido' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'email_verificado_en' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'reset_token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'reset_token_expira_en' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'estado_cuenta' => [
                'type'       => 'ENUM',
                'constraint' => ['activo', 'suspendido'],
                'default'    => 'activo',
            ],
            'estado_aprobacion' => [
                'type'       => 'ENUM',
                'constraint' => ['pendiente', 'aprobado', 'rechazado'],
                'default'    => 'aprobado',
                'comment'    => 'Solo vendedores nacen en pendiente; clientes y proveedores nacen aprobado',
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
        $this->forge->addKey('estado_aprobacion');
        $this->forge->addForeignKey('rol_id', 'roles', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
