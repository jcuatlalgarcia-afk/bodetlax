<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaOfertasProveedores extends Migration
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
            'proveedor_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'categoria_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'nombre_producto' => [
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
            'precio_ofertado' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'comment'    => 'Precio al que el proveedor ofrece vender al negocio',
            ],
            'cantidad_ofertada' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'imagen' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['pendiente', 'aceptada', 'rechazada', 'publicada'],
                'default'    => 'pendiente',
                'comment'    => 'publicada = ya se convirtió en producto del catálogo',
            ],
            'revisado_por' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'FK a usuarios, el admin que aceptó/rechazó',
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
        $this->forge->addForeignKey('proveedor_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('categoria_id', 'categorias', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('revisado_por', 'usuarios', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('ofertas_proveedores');
    }

    public function down()
    {
        $this->forge->dropTable('ofertas_proveedores');
    }
}
