<?php

namespace App\Controllers;

use App\Models\ContadoresModel;
use App\Models\ClientesModel;
use App\Models\TiposServicioModel;

class ContadoresController extends BaseController
{
    protected $contadoresModel;
    protected $clientesModel;
    protected $tiposServicioModel;

    public function __construct()
    {
        $this->contadoresModel    = new ContadoresModel();
        $this->clientesModel      = new ClientesModel();
        $this->tiposServicioModel = new TiposServicioModel();
    }

    // Listado de contadores, mostrando el nombre del cliente y del tipo de servicio
    // en vez de solo los ids (por eso usamos join)
    public function index()
    {
        $mostrarInactivos = $this->request->getGet('mostrar') === 'inactivos';

        $builder = $this->contadoresModel
            ->select('Contadores.*, Clientes.nombre as cliente_nombre, Tipos_Servicio.nombre as tipo_servicio_nombre')
            ->join('Clientes', 'Clientes.id = Contadores.cliente_id')
            ->join('Tipos_Servicio', 'Tipos_Servicio.id = Contadores.tipo_servicio_id');

        if (!$mostrarInactivos) {
            $builder->where('Contadores.activo', 1);
        }

        $contadores = $builder->findAll();

        return view('contadores/index', [
            'contadores'       => $contadores,
            'mostrarInactivos' => $mostrarInactivos,
        ]);
    }

    // Formulario para crear un contador nuevo
    public function nuevo()
    {
        return view('contadores/form', [
            'contador'      => null,
            'clientes'      => $this->clientesModel->where('activo', 1)->findAll(),
            'tiposServicio' => $this->tiposServicioModel->where('activo', 1)->findAll(),
        ]);
    }

    // Guarda el contador nuevo
    public function crear()
    {
        $reglas = [
            'cliente_id'        => 'required|is_natural_no_zero',
            'tipo_servicio_id'  => 'required|is_natural_no_zero',
            'codigo'            => 'required|max_length[20]|is_unique[Contadores.codigo]',
            'referencia'        => 'permit_empty|max_length[50]',
            'sector'            => 'permit_empty|max_length[50]',
            'ubicacion'         => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($reglas)) {
            return view('contadores/form', [
                'contador'      => null,
                'clientes'      => $this->clientesModel->where('activo', 1)->findAll(),
                'tiposServicio' => $this->tiposServicioModel->where('activo', 1)->findAll(),
                'errores'       => $this->validator->getErrors(),
            ]);
        }

        // fecha_instalacion y activo se calculan aqui, nunca desde el formulario
        $this->contadoresModel->insert([
            'cliente_id'        => $this->request->getPost('cliente_id'),
            'tipo_servicio_id'  => $this->request->getPost('tipo_servicio_id'),
            'codigo'            => $this->request->getPost('codigo'),
            'referencia'        => $this->request->getPost('referencia'),
            'sector'            => $this->request->getPost('sector'),
            'ubicacion'         => $this->request->getPost('ubicacion'),
            'fecha_instalacion' => date('Y-m-d'),
            'activo'            => 1,
        ]);

        return redirect()->to('/contadores')->with('mensaje', 'Contador registrado correctamente');
    }

    // Formulario de edicion, precargado
    public function editar($id)
    {
        $contador = $this->contadoresModel->find($id);

        if (!$contador) {
            return redirect()->to('/contadores')->with('error', 'Contador no encontrado');
        }

        return view('contadores/form', [
            'contador'      => $contador,
            'clientes'      => $this->clientesModel->where('activo', 1)->findAll(),
            'tiposServicio' => $this->tiposServicioModel->where('activo', 1)->findAll(),
        ]);
    }

    // Actualiza los datos del contador
    public function actualizar($id)
    {
        $contador = $this->contadoresModel->find($id);

        if (!$contador) {
            return redirect()->to('/contadores')->with('error', 'Contador no encontrado');
        }

        $reglas = [
            'cliente_id'       => 'required|is_natural_no_zero',
            'tipo_servicio_id' => 'required|is_natural_no_zero',
            // is_unique ignora el propio registro que se esta editando (id actual)
            'codigo'           => "required|max_length[20]|is_unique[Contadores.codigo,id,{$id}]",
            'referencia'       => 'permit_empty|max_length[50]',
            'sector'           => 'permit_empty|max_length[50]',
            'ubicacion'        => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($reglas)) {
            return view('contadores/form', [
                'contador'      => $contador,
                'clientes'      => $this->clientesModel->where('activo', 1)->findAll(),
                'tiposServicio' => $this->tiposServicioModel->where('activo', 1)->findAll(),
                'errores'       => $this->validator->getErrors(),
            ]);
        }

        // fecha_instalacion no se toca al actualizar, solo se definio al crear
        $this->contadoresModel->update($id, [
            'cliente_id'       => $this->request->getPost('cliente_id'),
            'tipo_servicio_id' => $this->request->getPost('tipo_servicio_id'),
            'codigo'           => $this->request->getPost('codigo'),
            'referencia'       => $this->request->getPost('referencia'),
            'sector'           => $this->request->getPost('sector'),
            'ubicacion'        => $this->request->getPost('ubicacion'),
        ]);

        return redirect()->to('/contadores')->with('mensaje', 'Contador actualizado correctamente');
    }

    // Soft delete: solo se marca activo=0, nunca se borra fisicamente
    public function desactivar($id)
    {
        $contador = $this->contadoresModel->find($id);

        if (!$contador) {
            return redirect()->to('/contadores')->with('error', 'Contador no encontrado');
        }

        $this->contadoresModel->update($id, ['activo' => 0]);

        return redirect()->to('/contadores')->with('mensaje', 'Contador desactivado correctamente');
    }

    // Reactiva un contador que había sido desactivado por error
    public function activar($id)
    {
        $contador = $this->contadoresModel->find($id);

        if (!$contador) {
            return redirect()->to('/contadores')->with('error', 'Contador no encontrado');
        }

        $this->contadoresModel->update($id, ['activo' => 1]);

        return redirect()->to('/contadores')->with('mensaje', 'Contador reactivado correctamente');
    }
}