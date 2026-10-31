<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table            = 'Clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'telefono', 'direccion', 'email', 'fecha_registro', 'activo', 'created_by', 'updated_by'];
    protected $useTimestamps    = false;
}
