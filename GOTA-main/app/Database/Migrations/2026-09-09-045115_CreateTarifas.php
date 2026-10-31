<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTarifas extends Migration
{
    public function up()
    {
        // Tarifas escalonadas por tipo de servicio: un precio para el
        // consumo dentro del volumen incluido (tarifa_base) y otro precio,
        // normalmente más alto, para lo que se pase de ese volumen
        // (tarifa_exceso). Cada tarifa tiene vigencia (desde/hasta), para
        // poder guardar el historial de cambios de precio sin perder los
        // cálculos ya hechos con precios anteriores.
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tipo_servicio_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, // debe coincidir con Tipos_Servicio.id
                'null'       => false,
                'comment'    => 'Referencia al catálogo de tipos',
            ],
            'volumen_incluido_m3' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => false,
                'comment'    => 'Metros cúbicos incluidos en tarifa base',
            ],
            'tarifa_base' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
                'comment'    => 'Tarifa por m³ dentro del volumen incluido',
            ],
            'tarifa_exceso' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
                'comment'    => 'Tarifa por m³ de excedente',
            ],
            'vigente_desde' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'vigente_hasta' => [
                'type' => 'DATE',
                'null' => true,
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
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('tipo_servicio_id', 'Tipos_Servicio', 'id', 'CASCADE', false, 'fk_tarifas_tipo_servicio');

        $this->forge->createTable('Tarifas');

        // Los CHECK constraints no tienen soporte directo en Forge,
        // así que se agregan con SQL crudo justo después de crear la tabla.
        // Repiten exactamente las mismas reglas de negocio del SQL original:
        // - vigente_hasta, si existe, no puede ser anterior a vigente_desde
        // - las tarifas no pueden ser negativas
        // - el volumen incluido no puede ser negativo
        $this->db->query('
            ALTER TABLE `Tarifas`
            ADD CONSTRAINT `chk_tarifas_fechas`
                CHECK ((`vigente_hasta` IS NULL) OR (`vigente_hasta` >= `vigente_desde`)),
            ADD CONSTRAINT `chk_tarifas_tarifas`
                CHECK ((`tarifa_base` >= 0) AND (`tarifa_exceso` >= 0)),
            ADD CONSTRAINT `chk_tarifas_volumen`
                CHECK (`volumen_incluido_m3` >= 0)
        ');
    }

    public function down()
    {
        $this->forge->dropTable('Tarifas');
    }
}