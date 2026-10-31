<?php

namespace App\Models;

use CodeIgniter\Model;

class HistorialModel extends Model
{
    protected $table            = 'Historial';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['contador_id', 'lectura_id', 'usuario_id', 'fecha_cambio', 'tipo_cambio', 'detalle', 'ip_origen'];
    protected $useTimestamps    = false;
}
