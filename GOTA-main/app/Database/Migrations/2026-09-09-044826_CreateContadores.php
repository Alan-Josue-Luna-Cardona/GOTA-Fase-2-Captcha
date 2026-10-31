<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContadores extends Migration
{
    public function up()
    {
        // Un Contador es el medidor físico instalado en la propiedad de
        // un Cliente. Un mismo Cliente puede tener varios Contadores
        // (confirmado con los Excel reales: hay usuarios con más de un
        // medidor, ej. casa + negocio en la misma dirección).
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cliente_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, // debe coincidir con Clientes.id (unsigned)
                'null'       => false,
            ],
            'codigo' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'referencia' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'sector' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'tipo_servicio_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, // debe coincidir con Tipos_Servicio.id (unsigned)
                'null'       => false,
                'comment'    => 'Tipo de servicio del contador',
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => true,
            ],
            'fecha_instalacion' => [
                'type'    => 'DATE',
                'null'    => true,
                'default' => new \CodeIgniter\Database\RawSql('(CURDATE())'),
            ],
            'ubicacion' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        // El código del contador es único (no puede haber dos medidores
        // con el mismo número de serie/código)
        $this->forge->addUniqueKey('codigo', 'uk_contadores_codigo');

        // Llaves foráneas reales: ambas tablas ya existen (las creamos antes)
        $this->forge->addForeignKey('cliente_id', 'Clientes', 'id', 'CASCADE', false, 'fk_contadores_cliente');
        $this->forge->addForeignKey('tipo_servicio_id', 'Tipos_Servicio', 'id', 'CASCADE', false, 'fk_contadores_tipo_servicio');

        $this->forge->createTable('Contadores');
    }

    public function down()
    {
        $this->forge->dropTable('Contadores');
    }
}