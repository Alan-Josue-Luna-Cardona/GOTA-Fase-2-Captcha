<?php

namespace App\Controllers;

use App\Models\PagosModel;
use App\Models\LecturasModel;

class Pagos extends BaseController
{
    protected PagosModel $pagosModel;
    protected LecturasModel $lecturasModel;

    // Catálogo simple de métodos de pago para el <select> del formulario.
    protected array $metodosPago = ['Efectivo', 'Transferencia', 'Depósito', 'Otro'];

    public function __construct()
    {
        $this->pagosModel    = new PagosModel();
        $this->lecturasModel = new LecturasModel();
    }

    /**
     * Listado de pagos, mostrando datos de la lectura asociada (cliente,
     * período, contador) en vez de solo IDs sueltos.
     */
    public function index()
    {
        $pagos = $this->pagosModel
            ->select('Pagos.*, Lecturas.periodo, Clientes.nombre as cliente_nombre, Contadores.codigo as contador_codigo')
            ->join('Lecturas', 'Lecturas.id = Pagos.lectura_id')
            ->join('Contadores', 'Contadores.id = Lecturas.contador_id')
            ->join('Clientes', 'Clientes.id = Contadores.cliente_id')
            ->orderBy('Pagos.fecha_registro', 'DESC')
            ->findAll();

        return view('pagos/index', [
            'pagos' => $pagos,
        ]);
    }

    /**
     * Lecturas que todavía no tienen un pago "vivo" (sin pago, o su único
     * pago quedó Anulado). Es la cola de trabajo para cobrar; los mismos
     * datos son los que puede reusar el Dashboard para su tarjeta de
     * pendientes.
     */
    public function pendientes()
    {
        return view('pagos/pendientes', [
            'lecturas' => $this->obtenerLecturasPendientes(),
        ]);
    }

    /**
     * Formulario para registrar el pago de una lectura específica.
     */
    public function registrar($lecturaId)
    {
        $lectura = $this->obtenerLecturaConDatos($lecturaId);

        if (!$lectura) {
            return redirect()->to('/pagos/pendientes')->with('error', 'La lectura que buscas no existe.');
        }

        if ((float) $lectura['monto_total'] <= 0) {
            return redirect()->to('/pagos/pendientes')->with('error', 'No se puede registrar un pago de Q0.00.');
        }

        if ($this->pagosModel->tienePagoActivo((int) $lecturaId)) {
            return redirect()->to('/pagos/pendientes')->with('error', 'Esta lectura ya tiene un pago registrado.');
        }

        return view('pagos/formulario', [
            'lectura' => $lectura,
            'metodos' => $this->metodosPago,
        ]);
    }

    /**
     * Guarda el pago. El monto NUNCA se toma del formulario: siempre se
     * recalcula tomando el monto_total real de la lectura (columna
     * calculada por la BD), para que nadie pueda manipular cuánto se cobra
     * editando el HTML del formulario.
     */
    public function guardar($lecturaId)
    {
        $lectura = $this->obtenerLecturaConDatos($lecturaId);

        if (!$lectura) {
            return redirect()->to('/pagos/pendientes')->with('error', 'La lectura que buscas no existe.');
        }

        if ((float) $lectura['monto_total'] <= 0) {
            return redirect()->to('/pagos/pendientes')->with('error', 'No se puede registrar un pago de Q0.00.');
        }

        // Un pago cubre una sola lectura: si ya hay uno activo, no se permite otro.
        if ($this->pagosModel->tienePagoActivo((int) $lecturaId)) {
            return redirect()->to('/pagos/pendientes')->with('error', 'Esta lectura ya tiene un pago registrado.');
        }

        $datos = [
            'lectura_id'       => (int) $lecturaId,
            'monto'            => $lectura['monto_total'],
            'metodo'           => $this->request->getPost('metodo'),
            'usuario_registro' => session()->get('usuario_id'),
            'comprobante'      => $this->request->getPost('comprobante') ?: null,
            'observaciones'    => $this->request->getPost('observaciones') ?: null,
            'estado'           => 'Completado',
        ];

        if (!$this->pagosModel->validate($datos)) {
            return redirect()->back()->withInput()->with('errores', $this->pagosModel->errors());
        }

        $this->pagosModel->insert($datos);

        return redirect()->to('/pagos')->with('exito', 'Pago registrado correctamente.');
    }

    /**
     * Anula un pago. No se borra: queda como historial y libera la lectura
     * para que se pueda registrar un pago nuevo si hizo falta corregirlo.
     */
    public function anular($id)
    {
        $pago = $this->pagosModel->find($id);

        if (!$pago) {
            return redirect()->to('/pagos')->with('error', 'El pago que buscas no existe.');
        }

        if ($pago['estado'] === 'Anulado') {
            return redirect()->to('/pagos')->with('error', 'Este pago ya estaba anulado.');
        }

        $this->pagosModel->update($id, ['estado' => 'Anulado']);

        return redirect()->to('/pagos')->with('exito', 'Pago anulado. La lectura vuelve a quedar pendiente de pago.');
    }

    /**
     * Trae una lectura junto con los datos de cliente/contador que se
     * muestran en el formulario de registro de pago.
     */
    private function obtenerLecturaConDatos($lecturaId): ?array
    {
        return $this->lecturasModel
            ->select('Lecturas.*, Clientes.nombre as cliente_nombre, Contadores.codigo as contador_codigo')
            ->join('Contadores', 'Contadores.id = Lecturas.contador_id')
            ->join('Clientes', 'Clientes.id = Contadores.cliente_id')
            ->where('Lecturas.id', $lecturaId)
            ->first();
    }

    /**
     * Lecturas sin ningún pago vivo todavía (sin pago, o su único pago
     * quedó Anulado).
     */
    private function obtenerLecturasPendientes(): array
    {
        return $this->lecturasModel
            ->select('Lecturas.*, Clientes.nombre as cliente_nombre, Contadores.codigo as contador_codigo')
            ->join('Contadores', 'Contadores.id = Lecturas.contador_id')
            ->join('Clientes', 'Clientes.id = Contadores.cliente_id')
            ->where('Lecturas.monto_total >', 0)
            ->whereNotIn('Lecturas.id', function ($builder) {
                return $builder->select('lectura_id')->from('Pagos')->where('estado !=', 'Anulado');
            })
            ->orderBy('Lecturas.periodo', 'ASC')
            ->findAll();
    }
}
