<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $token    = (string) ($_POST['g-recaptcha-response'] ?? '');

    if (! verificar_recaptcha($token)) {
        $error = 'Confirma que no eres un robot.';
    } else {
        $pdo = conexion_bd();
        $consulta = $pdo->prepare(
            'SELECT Usuarios.id, Usuarios.nombre, Usuarios.email, Usuarios.password_hash, Roles.nombre AS rol
             FROM Usuarios
             JOIN Roles ON Roles.id = Usuarios.rol_id
             WHERE Usuarios.email = :email
             LIMIT 1'
        );
        $consulta->execute(['email' => $email]);
        $usuario = $consulta->fetch();

        if (! $usuario || ! password_verify($password, $usuario['password_hash'])) {
            $error = 'Correo o contraseña incorrectos.';
        } else {
            $_SESSION['usuario'] = [
                'id'     => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email'  => $usuario['email'],
                'rol'    => $usuario['rol'],
            ];
            header('Location: bienvenida.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta pública con captcha · GOTA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php if (recaptcha_configurado()): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
    <style>
        body { background: #eef1f6; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: system-ui, sans-serif; }
        .card { max-width: 420px; width: 100%; border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.08); }
        .badge-modulo { font-size: .72rem; letter-spacing: .04em; }
    </style>
</head>
<body>
    <div class="card p-4 p-md-5">
        <span class="badge bg-primary-subtle text-primary badge-modulo mb-3">MÓDULO INDEPENDIENTE · CONSULTA PÚBLICA CON CAPTCHA</span>
        <h1 class="h3 mb-1">Iniciar sesión</h1>
        <p class="text-muted mb-4">Oficina del Agua (GOTA) — servicio separado del monolito.</p>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= esc($error) ?></div>
        <?php endif; ?>
        <?php if (! recaptcha_configurado()): ?>
            <div class="alert alert-warning py-2">
                Las llaves de reCAPTCHA no están configuradas en el <code>.env</code> de este módulo,
                así que la verificación se omite por ahora.
            </div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="mb-3">
                <label class="form-label" for="email">Correo</label>
                <input id="email" type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Contraseña</label>
                <input id="password" type="password" name="password" class="form-control" required>
            </div>

            <?php if (recaptcha_configurado()): ?>
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="<?= esc(recaptcha_site_key()) ?>"></div>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>

        <p class="text-center text-muted small mt-4 mb-0">
            ¿No tienes cuenta? <a href="crear-usuario.php">Crear usuario</a>
        </p>
    </div>
</body>
</html>
