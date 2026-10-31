<?php

namespace App\Controllers;

use App\Models\TarifasModel;
use App\Models\TiposServicioModel;

class Tarifas extends BaseController
{
    protected TarifasModel $tarifasModel;
    protected TiposServicioModel $tiposServicioModel;

    public function __construct()
    {
        $this->tarifasModel       = new TarifasModel();
        $this->tiposServicioModel = new TiposServicioModel();
    }

    /**
     * Listado de tarifas con el nombre del tipo de servicio (no el id),
     * ordenado por vigencia más reciente primero.
     */
    public function index()
    {
        $tarifas = $this->tarifasModel
            ->select('Tarifas.*, Tipos_Servicio.nombre as tipo_servicio_nombre')
            ->join('Tipos_Servicio', 'Tipos_Servicio.id = Tarifas.tipo_servicio_id')
            ->orderBy('Tarifas.vigente_desde', 'DESC')
            ->findAll();

        return view('tarifas/index', [
            'tarifas' => $tarifas,
        ]);
    }

    /**
     * Formulario para registrar una tarifa nueva.
     */
    public function nuevo()
    {
        return view('tarifas/formulario', [
            'tarifa'        => null,
            'tiposServicio' => $this->tiposServicioModel->where('activo', 1)->findAll(),
        ]);
    }

    /**
     * Guarda una tarifa nueva. Valida tipos de dato, rango de fechas y que
     * no se solape con otra tarifa activa del mismo tipo de servicio.
     */
    public function crear()
    {
        $datos = $this->obtenerDatosFormulario();

        if (!$this->tarifasModel->validate($datos)) {
            return redirect()->back()->withInput()->with('errores', $this->tarifasModel->errors());
        }

        if ($error = $this->validarRangoFechas($datos)) {
            return redirect()->back()->withInput()->with('error', $error);
        }

        if ($this->existeSolapamiento($datos)) {
            return redirect()->back()->withInput()->with(
                'error',
                'Ya existe una tarifa activa para este tipo de servicio en ese rango de fechas. '
                . 'Cierra o ajusta la vigencia de la tarifa anterior antes de crear una nueva.'
            );
        }

        $datos['fecha_creacion'] = date('Y-m-d H:i:s');

        $this->tarifasModel->insert($datos);

        return redirect()->to('/tarifas')->with('exito', 'Tarifa creada correctamente.');
    }

    /**
     * Formulario para editar una tarifa existente.
     */
    public function editar($id)
    {
        $tarifa = $this->tarifasModel->find($id);

        if (!$tarifa) {
            return redirect()->to('/tarifas')->with('error', 'La tarifa que buscas no existe.');
        }

        return view('tarifas/formulario', [
            'tarifa'        => $tarifa,
            'tiposServicio' => $this->tiposServicioModel->where('activo', 1)->findAll(),
        ]);
    }

    /**
     * Actualiza una tarifa existente, con las mismas validaciones que al crear.
     */
    public function actualizar($id)
    {
        $tarifa = $this->tarifasModel->find($id);

        if (!$tarifa) {
            return redirect()->to('/tarifas')->with('error', 'La tarifa que buscas no existe.');
        }

        $datos = $this->obtenerDatosFormulario();

        if (!$this->tarifasModel->validate($datos)) {
            return redirect()->back()->withInput()->with('errores', $this->tarifasModel->errors());
        }

        if ($error = $this->validarRangoFechas($datos)) {
            return redirect()->back()->withInput()->with('error', $error);
        }

        // Al editar excluimos la propia tarifa de la comprobación de solapamiento.
        if ($this->existeSolapamiento($datos, (int) $id)) {
            return redirect()->back()->withInput()->with(
                'error',
                'Ya existe otra tarifa activa para este tipo de servicio en ese rango de fechas.'
            );
        }

        $this->tarifasModel->update($id, $datos);

        return redirect()->to('/tarifas')->with('exito', 'Tarifa actualizada correctamente.');
    }

    /**
     * Activa o desactiva una tarifa. No se borra físicamente porque Lecturas
     * y Pagos pueden seguir haciendo referencia a tarifas históricas.
     */
    public function desactivar($id)
    {
        $tarifa = $this->tarifasModel->find($id);

        if (!$tarifa) {
            return redirect()->to('/tarifas')->with('error', 'La tarifa que buscas no existe.');
        }

        $nuevoEstado = $tarifa['activo'] ? 0 : 1;

        $this->tarifasModel->update($id, ['activo' => $nuevoEstado]);

        $mensaje = $nuevoEstado ? 'Tarifa activada.' : 'Tarifa desactivada.';

        return redirect()->to('/tarifas')->with('exito', $mensaje);
    }

    /**
     * Recolecta y normaliza los datos que llegan del formulario de tarifas.
     */
    private function obtenerDatosFormulario(): array
    {
        return [
            'tipo_servicio_id'    => $this->request->getPost('tipo_servicio_id'),
            'volumen_incluido_m3' => $this->request->getPost('volumen_incluido_m3') !== '' ? $this->request->getPost('volumen_incluido_m3') : 0,
            'tarifa_base'         => $this->request->getPost('tarifa_base'),
            'tarifa_exceso'       => $this->request->getPost('tarifa_exceso'),
            'vigente_desde'       => $this->request->getPost('vigente_desde'),
            'vigente_hasta'       => $this->request->getPost('vigente_hasta') ?: null,
            'activo'              => $this->request->getPost('activo') ? 1 : 0,
        ];
    }

    /**
     * Si hay fecha de fin, no puede ser anterior a la fecha de inicio.
     * Devuelve el mensaje de error, o null si el rango está bien.
     */
    private function validarRangoFechas(array $datos): ?string
    {
        if ($datos['vigente_hasta'] !== null && $datos['vigente_hasta'] < $datos['vigente_desde']) {
            return 'La fecha de fin de vigencia no puede ser anterior a la fecha de inicio.';
        }

        return null;
    }

    /**
     * Revisa si ya existe otra tarifa activa del mismo tipo de servicio cuyo
     * rango de vigencia se cruza con el que se está guardando. $excluirId se
     * usa al editar, para no comparar la tarifa contra sí misma.
     */
    private function existeSolapamiento(array $datos, ?int $excluirId = null): bool
    {
        // Si no hay fecha de fin, tratamos la vigencia como abierta hacia el futuro.
        $hastaComparacion = $datos['vigente_hasta'] ?? '9999-12-31';

        $consulta = $this->tarifasModel
            ->where('tipo_servicio_id', $datos['tipo_servicio_id'])
            ->where('activo', 1)
            ->where('vigente_desde <=', $hastaComparacion)
            ->groupStart()
                ->where('vigente_hasta >=', $datos['vigente_desde'])
                ->orWhere('vigente_hasta', null)
            ->groupEnd();

        if ($excluirId !== null) {
            $consulta->where('id !=', $excluirId);
        }

        return $consulta->countAllResults() > 0;
    }
}
