<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre' => 'Administrador'],
            ['nombre' => 'Secretaria'],
            ['nombre' => 'Lector'],
        ];
        $this->db->table('Roles')->insertBatch($data);
    }
}