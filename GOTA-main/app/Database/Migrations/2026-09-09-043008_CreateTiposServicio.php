<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTiposServicio extends Migration
{
    public function up()
    {
        // Catálogo de tipos de servicio de agua (Residencial, Comercial,
        // Industrial, Institucional). Cada Contador y cada Tarifa se
        // clasifican según este tipo, para poder cobrar distinto según
        // el tipo de cliente.
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'comment'    => 'Ej: Residencial, Comercial, Industrial, Institucional',
            ],
            'descripcion' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => true,
            ],
            'fecha_creacion' => [
                'type'    => 'DATETIME',
                'null'    => true,
                // CURRENT_TIMESTAMP como default real de la columna,
                // igual que en la base de datos ya desplegada.
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        // El nombre no se puede repetir (no puede haber dos "Residencial")
        $this->forge->addUniqueKey('nombre', 'uk_tipo_servicio_nombre');

        $this->forge->createTable('Tipos_Servicio');
    }

    public function down()
    {
        $this->forge->dropTable('Tipos_Servicio');
    }
}