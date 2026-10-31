<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolesModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->findByEmail($email);

        if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
            return redirect()->back()->with('error', 'Correo o contraseña incorrectos');
        }

        $rol = (new RolesModel())->find($usuario['rol_id']);

        // Guardamos los datos importantes en la sesión
        session()->set([
            'usuario_id'     => $usuario['id'],
            'usuario_nombre' => $usuario['nombre'],
            'rol_id'         => $usuario['rol_id'],
            'rol_nombre'     => $rol['nombre'] ?? null,
            'isLoggedIn'     => true,
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('mensaje', 'Sesión cerrada exitosamente');
    }
}