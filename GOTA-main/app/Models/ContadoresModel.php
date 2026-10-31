<?php

namespace App\Models;

use CodeIgniter\Model;

class ContadoresModel extends Model
{
    protected $table            = 'Contadores';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['cliente_id', 'codigo', 'referencia', 'sector', 'tipo_servicio_id', 'activo', 'fecha_instalacion', 'ubicacion', 'deleted_at'];
    protected $useTimestamps    = false;
}
