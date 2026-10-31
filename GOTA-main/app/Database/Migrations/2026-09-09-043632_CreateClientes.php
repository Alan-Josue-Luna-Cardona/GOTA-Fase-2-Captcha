<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientes extends Migration
{
    public function up()
    {
        // Clientes de la oficina de agua: personas o negocios/instituciones
        // (según vimos en los Excel reales: escuelas, restaurantes, clínicas
        // conviven con casas particulares, todos como "Clientes").
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'telefono' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'direccion' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'fecha_registro' => [
                'type'    => 'DATE',
                'null'    => true,
                // CURDATE() como default, igual que en la BD real
                'default' => new \CodeIgniter\Database\RawSql('(CURDATE())'),
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('Clientes');
    }

    public function down()
    {
        $this->forge->dropTable('Clientes');
    }
}