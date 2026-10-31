<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Agrega la auditoría básica a la tabla Clientes:
 * - created_by: usuario que registró al cliente (id de Usuarios).
 * - updated_by: último usuario que editó al cliente (id de Usuarios).
 *
 * No se crea un historial de logs: solo se guarda quién creó y quién
 * editó por última vez, y se expone en la vista de detalle.
 */
class AddAuditoriaClientes extends Migration
{
    public function up()
    {
        $this->forge->addColumn('Clientes', [
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'activo',
            ],
            'updated_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'created_by',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('Clientes', ['created_by', 'updated_by']);
    }
}