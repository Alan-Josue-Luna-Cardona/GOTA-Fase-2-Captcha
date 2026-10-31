<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioAdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nombre'        => 'Admin Prueba',
            'email'         => 'admin@oficina.test',
            'password_hash' => password_hash('123456', PASSWORD_DEFAULT),
            'rol_id'        => 1, // Administrador
            'created_at'    => date('Y-m-d H:i:s'),
        ];
        $this->db->table('Usuarios')->insert($data);
    }
}