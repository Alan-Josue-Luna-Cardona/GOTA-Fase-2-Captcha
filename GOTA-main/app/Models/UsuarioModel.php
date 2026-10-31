<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'Usuarios';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nombre', 'email', 'password_hash', 'rol_id', 'activo', 'ultimo_acceso'];
    protected $useTimestamps    = false;

    protected $validationRules = [
        'nombre' => 'required|min_length[3]',
        'email'  => 'required|valid_email|is_unique[Usuarios.email,id,{id}]',
        'rol_id' => 'required|integer',
    ];

    // Busca un usuario por email (lo usamos para el login)
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}