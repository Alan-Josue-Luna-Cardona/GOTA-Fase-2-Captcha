<?php

namespace App\Models;

use CodeIgniter\Model;

class PagosModel extends Model
{
    protected $table            = 'Pagos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['lectura_id', 'monto', 'fecha_pago', 'metodo', 'usuario_registro', 'comprobante', 'observaciones', 'estado', 'fecha_registro'];
    protected $useTimestamps    = false;

    protected $validationRules = [
        'lectura_id'       => 'required|is_natural_no_zero|is_not_unique[Lecturas.id]',
        'monto'            => 'required|decimal|greater_than[0]',
        'metodo'           => 'required|max_length[30]',
        'usuario_registro' => 'required|is_natural_no_zero|is_not_unique[Usuarios.id]',
        'comprobante'      => 'permit_empty|max_length[100]',
        'observaciones'    => 'permit_empty|max_length[200]',
        'estado'           => 'permit_empty|in_list[Completado,Pendiente,Anulado]',
    ];

    protected $validationMessages = [
        'lectura_id' => [
            'required'      => 'Falta indicar a qué lectura corresponde el pago.',
            'is_not_unique' => 'La lectura indicada no existe.',
        ],
        'monto' => [
            'required'     => 'El monto es obligatorio.',
            'greater_than' => 'El monto debe ser mayor a cero.',
        ],
        'metodo' => [
            'required' => 'Debes indicar el método de pago.',
        ],
        'usuario_registro' => [
            'required'      => 'No se pudo identificar al usuario que registra el pago.',
            'is_not_unique' => 'El usuario que registra el pago no existe.',
        ],
        'estado' => [
            'in_list' => 'El estado del pago no es válido.',
        ],
    ];

    /**
     * true si la lectura ya tiene un pago que no está Anulado (Completado
     * o Pendiente). Un pago cubre una sola lectura: si ya hay uno activo
     * no se permite registrar otro, salvo que primero se anule el anterior.
     */
    public function tienePagoActivo(int $lecturaId, ?int $excluirId = null): bool
    {
        $consulta = $this->where('lectura_id', $lecturaId)
            ->where('estado !=', 'Anulado');

        if ($excluirId !== null) {
            $consulta->where('id !=', $excluirId);
        }

        return $consulta->countAllResults() > 0;
    }
}
