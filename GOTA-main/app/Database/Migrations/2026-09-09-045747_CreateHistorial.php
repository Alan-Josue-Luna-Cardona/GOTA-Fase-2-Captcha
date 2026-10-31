<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHistorial extends Migration
{
    public function up()
    {
        // Registro de auditoría: guarda un rastro de cambios importantes
        // hechos en Contadores o Lecturas (ej. "se corrigió una lectura",
        // "se desactivó un contador"). IMPORTANTE: esta tabla no se llena
        // sola — cada módulo que quiera dejar rastro aquí debe insertar
        // explícitamente un registro cuando haga el cambio correspondiente.
        // Si el equipo decide no usar auditoría por ahora, esta tabla
        // puede quedar creada pero sin uso, sin afectar nada más.
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
                'null'       => true,
            ],
            'lectura_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'fecha_cambio' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'tipo_cambio' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => false,
            ],
            'detalle' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false,
            ],
            'ip_origen' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        // Las 3 FK usan "SET NULL" al eliminar: si se borra el contador,
        // la lectura o el usuario referenciado, el registro de historial
        // se conserva (no se borra la auditoría), solo pierde la referencia.
        $this->forge->addForeignKey('contador_id', 'Contadores', 'id', 'CASCADE', 'SET NULL', 'fk_historial_contador');
        $this->forge->addForeignKey('lectura_id', 'Lecturas', 'id', 'CASCADE', 'SET NULL', 'fk_historial_lectura');
        $this->forge->addForeignKey('usuario_id', 'Usuarios', 'id', 'CASCADE', 'SET NULL', 'fk_historial_usuario');

        $this->forge->createTable('Historial');
    }

    public function down()
    {
        $this->forge->dropTable('Historial');
    }
}