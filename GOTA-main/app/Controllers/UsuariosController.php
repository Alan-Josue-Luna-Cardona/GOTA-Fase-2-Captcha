<?php

namespace App\Controllers;

use App\Models\RolesModel;
use App\Models\UsuarioModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class UsuariosController extends BaseController
{
    protected UsuarioModel $usuarioModel;
    protected RolesModel $rolesModel;
    protected array $validationErrors = [];

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolesModel = new RolesModel();
    }

    public function index()
    {
        if (! $this->isAdministrator()) {
            return $this->accessDenied();
        }

        $usuarios = $this->usuarioModel
            ->select('Usuarios.*, Roles.nombre AS rol_nombre')
            ->join('Roles', 'Roles.id = Usuarios.rol_id')
            ->orderBy('Usuarios.nombre', 'ASC')
            ->findAll();

        return view('usuarios/index', ['usuarios' => $usuarios]);
    }

    public function nuevo()
    {
        if (! $this->isAdministrator()) {
            return $this->accessDenied();
        }

        return view('usuarios/formulario', [
            'usuario' => null,
            'roles'   => $this->rolesModel->orderBy('nombre', 'ASC')->findAll(),
        ]);
    }

    public function crear()
    {
        if (! $this->isAdministrator()) {
            return $this->accessDenied();
        }

        $datos = $this->validatedData();
        if ($datos === null) {
            return redirect()->back()->withInput()->with('errores', $this->validationErrors);
        }

        $datos['password_hash'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        unset($datos['password']);

        try {
            $insertado = $this->usuarioModel
                ->skipValidation(true)
                ->insert($datos);
        } catch (DatabaseException $exception) {
            log_message('error', 'No se pudo crear el usuario: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()->withInput()->with(
                'error',
                'No se pudo crear el usuario. Verifica que el correo no esté repetido y que el rol sea válido.'
            );
        }

        if (! $insertado) {
            return redirect()->back()->withInput()->with('error', 'No se pudo crear el usuario.');
        }

        return redirect()->to('/usuarios')->with('exito', 'Usuario creado correctamente.');
    }

    public function editar(int $id)
    {
        if (! $this->isAdministrator()) {
            return $this->accessDenied();
        }

        $usuario = $this->usuarioModel->find($id);
        if (! $usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('usuarios/formulario', [
            'usuario' => $usuario,
            'roles'   => $this->rolesModel->orderBy('nombre', 'ASC')->findAll(),
        ]);
    }

    public function actualizar(int $id)
    {
        if (! $this->isAdministrator()) {
            return $this->accessDenied();
        }

        $usuario = $this->usuarioModel->find($id);
        if (! $usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $datos = $this->validatedData($id, false);
        if ($datos === null) {
            return redirect()->back()->withInput()->with('errores', $this->validationErrors);
        }

        $password = $datos['password'];
        unset($datos['password']);
        if ($password !== '') {
            $datos['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (! $this->usuarioModel->update($id, $datos)) {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar el usuario.');
        }

        return redirect()->to('/usuarios')->with('exito', 'Usuario actualizado correctamente.');
    }

    private function validatedData(?int $id = null, bool $passwordRequired = true): ?array
    {
        $nombre = trim((string) $this->request->getPost('nombre'));
        $email = trim((string) $this->request->getPost('email'));
        $rolId = (int) $this->request->getPost('rol_id');
        $password = (string) $this->request->getPost('password');

        $errores = [];
        if (mb_strlen($nombre) < 3) {
            $errores[] = 'El nombre debe tener al menos 3 caracteres.';
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'Ingresa un correo electrónico válido.';
        }
        if (! $this->rolesModel->find($rolId)) {
            $errores[] = 'Selecciona un rol válido.';
        }
        if ($passwordRequired && mb_strlen($password) < 6) {
            $errores[] = 'La contraseña debe tener al menos 6 caracteres.';
        }
        if (! $passwordRequired && $password !== '' && mb_strlen($password) < 6) {
            $errores[] = 'La nueva contraseña debe tener al menos 6 caracteres.';
        }

        $emailQuery = $this->usuarioModel->where('email', $email);
        if ($id !== null) {
            $emailQuery->where('id !=', $id);
        }
        if ($emailQuery->first()) {
            $errores[] = 'Ese correo ya está registrado.';
        }

        if ($errores !== []) {
            $this->validationErrors = $errores;
            return null;
        }

        return [
            'nombre'   => $nombre,
            'email'    => $email,
            'rol_id'   => $rolId,
            'password' => $password,
        ];
    }

    private function isAdministrator(): bool
    {
        return in_array(
            mb_strtolower(trim((string) session()->get('rol_nombre'))),
            ['desarrollador', 'administrador'],
            true
        );

    }

    private function accessDenied()
    {
        return redirect()->to('/dashboard')->with('error', 'No tienes permisos para administrar usuarios.');
    }
}
