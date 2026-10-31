<?php

namespace App\Controllers;

use App\Models\TiposServicioModel;

class TiposServicio extends BaseController
{
    protected TiposServicioModel $tipoServicioModel;

    public function __construct()
    {
        $this->tipoServicioModel = new TiposServicioModel();
    }

    /**
     * Listado de tipos de servicio. Por defecto solo muestra los activos;
     * con ?ver=todos también se ven los desactivados (soft delete).
     * Ruta: GET /tipos-servicio
     */
    public function index()
    {
        $verTodos = $this->request->getGet('ver') === 'todos';

        $tipos = $verTodos
            ? $this->tipoServicioModel->orderBy('nombre', 'ASC')->findAll()
            : $this->tipoServicioModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll();

        return view('tipos_servicio/index', [
            'tipos'    => $tipos,
            'verTodos' => $verTodos,
        ]);
    }

    /**
     * Formulario para crear un tipo de servicio nuevo.
     * Ruta: GET /tipos-servicio/nuevo
     */
    public function nuevo()
    {
        return view('tipos_servicio/formulario', [
            'tipo'  => null, // null = estamos creando, no editando
            'modo'  => 'crear',
        ]);
    }

    /**
     * Procesa el formulario de creación.
     * Ruta: POST /tipos-servicio/crear
     */
    public function crear()
    {
        $nombre = trim((string) $this->request->getPost('nombre'));

        if ($nombre === '') {
            return redirect()->back()->withInput()
                ->with('error', 'El nombre es obligatorio.');
        }

        // El nombre debe ser único (regla de la propia BD: uk_tipo_servicio_nombre).
        // Lo validamos también aquí para dar un mensaje claro en vez de que
        // el usuario vea un error crudo de SQL si intenta repetir un nombre.
        $existe = $this->tipoServicioModel->where('nombre', $nombre)->first();
        if ($existe) {
            return redirect()->back()->withInput()
                ->with('error', 'Ya existe un tipo de servicio con ese nombre.');
        }

        $data = [
            'nombre'      => $nombre,
            'descripcion' => trim((string) $this->request->getPost('descripcion')) ?: null,
            'activo'      => 1,
        ];

        $insertado = $this->tipoServicioModel->insert($data);

        if (! $insertado) {
            return redirect()->back()->withInput()
                ->with('error', 'No se pudo guardar el tipo de servicio.');
        }

        return redirect()->to('/tipos-servicio')
            ->with('exito', 'Tipo de servicio creado correctamente.');
    }

    /**
     * Formulario para editar un tipo de servicio existente.
     * Ruta: GET /tipos-servicio/editar/{id}
     */
    public function editar(int $id)
    {
        $tipo = $this->tipoServicioModel->find($id);

        if (! $tipo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('tipos_servicio/formulario', [
            'tipo' => $tipo,
            'modo' => 'editar',
        ]);
    }

    /**
     * Procesa el formulario de edición.
     * Ruta: POST /tipos-servicio/actualizar/{id}
     */
    public function actualizar(int $id)
    {
        $tipo = $this->tipoServicioModel->find($id);
        if (! $tipo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $nombre = trim((string) $this->request->getPost('nombre'));

        if ($nombre === '') {
            return redirect()->back()->withInput()
                ->with('error', 'El nombre es obligatorio.');
        }

        // Verificar nombre único, mismo criterio que en crear(), pero
        // excluyendo el propio registro que estamos editando.
        $existe = $this->tipoServicioModel
            ->where('nombre', $nombre)
            ->where('id !=', $id)
            ->first();
        if ($existe) {
            return redirect()->back()->withInput()
                ->with('error', 'Ya existe otro tipo de servicio con ese nombre.');
        }

        $data = [
            'nombre'      => $nombre,
            'descripcion' => trim((string) $this->request->getPost('descripcion')) ?: null,
        ];

        $this->tipoServicioModel->update($id, $data);

        return redirect()->to('/tipos-servicio')
            ->with('exito', 'Tipo de servicio actualizado correctamente.');
    }

    /**
     * Desactiva un tipo de servicio (soft delete: activo = 0).
     * NUNCA se borra físicamente, porque Contadores y Tarifas dependen
     * de esta tabla por llave foránea — borrar de verdad rompería esos
     * registros existentes.
     * Ruta: POST /tipos-servicio/desactivar/{id}
     */
    public function desactivar(int $id)
    {
        $tipo = $this->tipoServicioModel->find($id);
        if (! $tipo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->tipoServicioModel->update($id, ['activo' => 0]);

        return redirect()->to('/tipos-servicio')
            ->with('exito', 'Tipo de servicio desactivado.');
    }

    /**
     * Reactiva un tipo de servicio que había sido desactivado.
     * Ruta: POST /tipos-servicio/activar/{id}
     */
    public function activar(int $id)
    {
        $tipo = $this->tipoServicioModel->find($id);
        if (! $tipo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->tipoServicioModel->update($id, ['activo' => 1]);

        return redirect()->to('/tipos-servicio')
            ->with('exito', 'Tipo de servicio reactivado.');
    }
}