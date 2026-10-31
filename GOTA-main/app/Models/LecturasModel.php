<?php

namespace App\Models;

use CodeIgniter\Model;

class LecturasModel extends Model
{
    protected $table            = 'Lecturas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'contador_id', 'lectura_anterior', 'lectura_actual', 'tarifa_id',
        'volumen_base_m3', 'consumo_base_m3', 'consumo_exceso_m3',
        'tarifa_base_valor', 'tarifa_exceso_valor', 'monto_base', 'monto_exceso',
        'fecha_lectura', 'usuario_lector_id', 'observaciones', 'periodo',
        // 'consumo' y 'monto_total' NO van aquí: son columnas STORED
        // GENERATED en MySQL, se calculan solas y dan error si se insertan.
    ];
    protected $useTimestamps = false;

    /**
     * Busca la última lectura registrada para un contador específico.
     */
    public function obtenerUltimaLectura(int $contadorId): ?array
    {
        return $this->where('contador_id', $contadorId)
                    ->orderBy('fecha_lectura', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->first();
    }
}