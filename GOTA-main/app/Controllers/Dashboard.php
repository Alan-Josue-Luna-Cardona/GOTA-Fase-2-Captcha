<?php

namespace App\Controllers;

use App\Models\ClientesModel;
use App\Models\ContadoresModel;
use App\Models\LecturasModel;
use App\Models\PagosModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $clientesModel = new ClientesModel();
        $contadoresModel = new ContadoresModel();
        $lecturasModel = new LecturasModel();
        $pagosModel = new PagosModel();

        // Obtener datos reales de la BD
        $totalClientes = $clientesModel->where('activo', 1)->countAllResults();
        $totalContadores = $contadoresModel->where('activo', 1)->countAllResults();

        // Consumo total del mes actual
        $consumoTotal = $lecturasModel
            ->selectSum('consumo')
            ->where('MONTH(fecha_lectura)', date('m'))
            ->where('YEAR(fecha_lectura)', date('Y'))
            ->get()
            ->getRow()
            ->consumo ?? 0;

        // Ingresos del mes
        $ingresosMes = $pagosModel
            ->selectSum('monto')
            ->where('MONTH(fecha_pago)', date('m'))
            ->where('YEAR(fecha_pago)', date('Y'))
            ->where('estado', 'Completado')
            ->get()
            ->getRow()
            ->monto ?? 0;

        // Lecturas pendientes (sin pago registrado)
        $lecturasPendientes = $lecturasModel
            ->select('Lecturas.*, Clientes.nombre as cliente_nombre, Contadores.codigo as contador_codigo')
            ->join('Contadores', 'Contadores.id = Lecturas.contador_id')
            ->join('Clientes', 'Clientes.id = Contadores.cliente_id')
            ->where('Lecturas.monto_total >', 0)
            ->whereNotIn('Lecturas.id', function($builder) {
                return $builder->select('lectura_id')->from('Pagos')->where('estado', 'Completado');
            })
            ->findAll();

        // OJO: 'monto' no existe en Lecturas. El monto real de cada lectura
        // es 'monto_total' (columna calculada por la BD a partir de
        // monto_base + monto_exceso). Sin este ajuste, el dashboard siempre
        // mostraba $0.
        $montoPendiente = array_sum(array_column($lecturasPendientes, 'monto_total'));

        $data = [
            'totalClientes' => $totalClientes,
            'totalContadores' => $totalContadores,
            'consumoTotal' => $consumoTotal,
            'ingresosMes' => $ingresosMes,
            'lecturasPendientes' => count($lecturasPendientes),
            'montoPendiente' => $montoPendiente,
            'lecturas' => $lecturasPendientes,
            // Estas métricas aún no tienen una fuente en el esquema actual.
            // Se muestran en cero hasta que exista su módulo o sus columnas.
            'tasaEntrega' => 0,
            'tasaApertura' => 0,
            'reenvios' => 0,
            'reportesAbuso' => 0,
            'clientesNuevos' => $clientesModel->where('activo', 1)->where('MONTH(fecha_registro)', date('m'))->countAllResults(),
            'pagosMes' => $pagosModel->where('MONTH(fecha_pago)', date('m'))->where('YEAR(fecha_pago)', date('Y'))->where('estado', 'Completado')->countAllResults(),
            'lecturasMes' => $lecturasModel->where('MONTH(fecha_lectura)', date('m'))->where('YEAR(fecha_lectura)', date('Y'))->countAllResults(),
            'clientesPorcentaje' => 0,
            'consumoPorcentaje' => 0,
            'ingresosPorcentaje' => 0,
            'pendientesPorcentaje' => 0,
            'inicio' => 1,
            'fin' => min(5, count($lecturasPendientes)),
            'totalRegistros' => count($lecturasPendientes),
            'paginaActual' => 1,
            'totalPaginas' => max(1, ceil(count($lecturasPendientes) / 5)),
        ];

        return view('dashboard/index', $data);
    }
}