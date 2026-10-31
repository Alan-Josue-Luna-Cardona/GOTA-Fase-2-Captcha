<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLecturas extends Migration
{
    public function up()
    {
        // Registro de cada lectura de contador. El consumo y el monto
        // total NO se llenan manualmente desde el código: son columnas
        // calculadas por la propia base de datos (ver el ALTER TABLE al
        // final de este método), para que el dato quede siempre
        // consistente sin depender de que el código haga bien la resta
        // o la suma cada vez.
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'contador_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'lectura_anterior' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => true,
            ],
            'lectura_actual' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            // 'consumo' se agrega después con SQL crudo (columna GENERADA)
            'tarifa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'ID de la tarifa aplicada',
            ],
            'volumen_base_m3' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => true,
                'comment'    => 'Volumen incluido en tarifa base (m³)',
            ],
            'consumo_base_m3' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => true,
                'comment'    => 'Consumo cubierto por tarifa base (m³)',
            ],
            'consumo_exceso_m3' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => true,
                'comment'    => 'Consumo excedente (m³)',
            ],
            'tarifa_base_valor' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'default'    => 0.0000,
                'null'       => true,
                'comment'    => 'Valor de tarifa base aplicada',
            ],
            'tarifa_exceso_valor' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'default'    => 0.0000,
                'null'       => true,
                'comment'    => 'Valor de tarifa exceso aplicada',
            ],
            'monto_base' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => true,
                'comment'    => 'Monto por consumo base',
            ],
            'monto_exceso' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => true,
                'comment'    => 'Monto por consumo excedente',
            ],
            // 'monto_total' se agrega después con SQL crudo (columna GENERADA)
            'fecha_lectura' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'usuario_lector_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'observaciones' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'periodo' => [
                'type' => 'DATE',
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('contador_id', 'Contadores', 'id', 'CASCADE', false, 'fk_lecturas_contador');
        $this->forge->addForeignKey('tarifa_id', 'Tarifas', 'id', 'CASCADE', 'SET NULL', 'fk_lecturas_tarifa');
        $this->forge->addForeignKey('usuario_lector_id', 'Usuarios', 'id', 'CASCADE', false, 'fk_lecturas_usuario');

        $this->forge->createTable('Lecturas');

        // Columnas GENERADAS (calculadas por MySQL, no se insertan manualmente):
        // - consumo = lectura_actual - lectura_anterior (mínimo 0, nunca negativo)
        // - monto_total = monto_base + monto_exceso
        // Forge no soporta columnas "GENERATED", así que se agregan con SQL crudo.
        $this->db->query('
            ALTER TABLE `Lecturas`
            ADD COLUMN `consumo` DECIMAL(10,2)
                AS (GREATEST((`lectura_actual` - `lectura_anterior`), 0)) STORED
                AFTER `lectura_actual`,
            ADD COLUMN `monto_total` DECIMAL(10,2)
                AS (COALESCE(`monto_base`, 0) + COALESCE(`monto_exceso`, 0)) STORED
                COMMENT \'Monto total calculado\'
                AFTER `monto_exceso`
        ');

        // CHECK: la lectura actual nunca puede ser menor a la anterior
        // (refuerza a nivel de BD la misma validación que ya hace el
        // controlador, por si algo intenta saltarse esa validación)
        $this->db->query('
            ALTER TABLE `Lecturas`
            ADD CONSTRAINT `chk_lecturas_consumo`
                CHECK (`lectura_actual` >= `lectura_anterior`)
        ');
    }

    public function down()
    {
        $this->forge->dropTable('Lecturas');
    }
}