<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nombre'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'rol_id'        => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rol_id', 'Roles', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('Usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('Usuarios');
    }
}
