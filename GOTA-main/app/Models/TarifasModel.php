<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifasModel extends Model
{
    protected $table            = 'Tarifas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['tipo_servicio_id', 'volumen_incluido_m3', 'tarifa_base', 'tarifa_exceso', 'vigente_desde', 'vigente_hasta', 'activo', 'fecha_creacion'];
    protected $useTimestamps    = false;

    // Validación a nivel de aplicación. Los CHECK de la BD son el respaldo final,
    // pero esto es lo que le da feedback claro al usuario en el formulario.
    protected $validationRules = [
        'tipo_servicio_id'    => 'required|is_natural_no_zero|is_not_unique[Tipos_Servicio.id]',
        'volumen_incluido_m3' => 'permit_empty|decimal|greater_than_equal_to[0]',
        'tarifa_base'         => 'required|decimal|greater_than_equal_to[0]',
        'tarifa_exceso'       => 'required|decimal|greater_than_equal_to[0]',
        'vigente_desde'       => 'required|valid_date[Y-m-d]',
        'vigente_hasta'       => 'permit_empty|valid_date[Y-m-d]',
    ];

    protected $validationMessages = [
        'tipo_servicio_id' => [
            'required'       => 'Debes seleccionar un tipo de servicio.',
            'is_not_unique'  => 'El tipo de servicio seleccionado no existe.',
        ],
        'volumen_incluido_m3' => [
            'greater_than_equal_to' => 'El volumen incluido no puede ser negativo.',
        ],
        'tarifa_base' => [
            'required'               => 'La tarifa base es obligatoria.',
            'greater_than_equal_to'  => 'La tarifa base no puede ser negativa.',
        ],
        'tarifa_exceso' => [
            'required'               => 'La tarifa de exceso es obligatoria.',
            'greater_than_equal_to'  => 'La tarifa de exceso no puede ser negativa.',
        ],
        'vigente_desde' => [
            'required'   => 'La fecha de inicio de vigencia es obligatoria.',
            'valid_date' => 'La fecha de inicio no es válida.',
        ],
        'vigente_hasta' => [
            'valid_date' => 'La fecha de fin no es válida.',
        ],
    ];

    /**
     * Busca la tarifa activa de un tipo de servicio para una fecha dada.
     * vigente_hasta en null significa que la tarifa sigue vigente indefinidamente.
     *
     * Usada por Lecturas para calcular montos; el nombre y comportamiento
     * deben mantenerse así porque ya hay otro módulo que depende de esto.
     */
    public function obtenerTarifaVigente(int $tipoServicioId, string $fecha): ?array
    {
        return $this->where('tipo_servicio_id', $tipoServicioId)
            ->where('activo', 1)
            ->where('vigente_desde <=', $fecha)
            ->groupStart()
                ->where('vigente_hasta >=', $fecha)
                ->orWhere('vigente_hasta', null)
            ->groupEnd()
            ->orderBy('vigente_desde', 'DESC')
            ->first();
    }
}
