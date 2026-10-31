<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'     => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nombre' => ['type' => 'VARCHAR', 'constraint' => 50], // Administrador, Secretaria, Lector
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('Roles');
    }

    public function down()
    {
        $this->forge->dropTable('Roles');
    }
}