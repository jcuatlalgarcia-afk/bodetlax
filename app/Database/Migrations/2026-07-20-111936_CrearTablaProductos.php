<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaProductos extends Migration
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
            'publicado_por' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'comment'    => 'FK a usuarios (vendedor/empleado que publicó, ya no dueño)',
            ],
            'oferta_origen_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'FK opcional a ofertas_proveedores, trazabilidad',
            ],
            'categoria_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'unidad_medida' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'precio' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'comment'    => 'Precio de reventa al cliente',
            ],
            'precio_descuento' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'imagen_principal' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['activo', 'inactivo'],
                'default'    => 'activo',
                'comment'    => 'Ya no requiere aprobación de admin, el vendedor es empleado de confianza',
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
        $this->forge->addKey('categoria_id');
        $this->forge->addForeignKey('publicado_por', 'usuarios', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('categoria_id', 'categorias', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('oferta_origen_id', 'ofertas_proveedores', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('productos');
    }

    public function down()
    {
        $this->forge->dropTable('productos');
    }
}
