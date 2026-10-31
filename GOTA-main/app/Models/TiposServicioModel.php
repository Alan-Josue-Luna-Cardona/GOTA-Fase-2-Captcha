<?php

namespace App\Models;

use CodeIgniter\Model;

class TiposServicioModel extends Model
{
    protected $table            = 'Tipos_Servicio';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'descripcion', 'activo', 'fecha_creacion'];
    protected $useTimestamps    = false;
}
