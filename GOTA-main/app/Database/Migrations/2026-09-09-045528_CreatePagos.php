<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagos extends Migration
{
    public function up()
    {
        // Registro de pagos: 1 pago cubre 1 lectura pendiente (regla de
        // negocio simple, según el alcance original del proyecto — no se
        // permiten pagos parciales ni un pago cubriendo varias lecturas).
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'lectura_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'monto' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'fecha_pago' => [
                'type'    => 'DATE',
                'null'    => true,
                'default' => new \CodeIgniter\Database\RawSql('(CURDATE())'),
            ],
            'metodo' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => false,
            ],
            'usuario_registro' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'comprobante' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'observaciones' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'estado' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'Completado',
                'null'       => true,
            ],
            'fecha_registro' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('lectura_id', 'Lecturas', 'id', 'CASCADE', false, 'fk_pagos_lectura');
        $this->forge->addForeignKey('usuario_registro', 'Usuarios', 'id', 'CASCADE', false, 'fk_pagos_usuario');

        $this->forge->createTable('Pagos');

        // CHECK: el estado solo puede ser uno de estos 3 valores exactos,
        // y el monto de un pago siempre debe ser positivo (no tendría
        // sentido un pago de Q0 o negativo).
        $this->db->query("
            ALTER TABLE `Pagos`
            ADD CONSTRAINT `chk_pagos_estado`
                CHECK (`estado` IN ('Completado', 'Pendiente', 'Anulado')),
            ADD CONSTRAINT `chk_pagos_monto`
                CHECK (`monto` > 0)
        ");
    }

    public function down()
    {
        $this->forge->dropTable('Pagos');
    }
}