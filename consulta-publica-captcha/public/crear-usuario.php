<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

$pdo   = conexion_bd();
$roles = $pdo->query('SELECT id, nombre FROM Roles ORDER BY nombre ASC')->fetchAll();

$error  = null;
$exito  = null;
$nombre = '';
$email  = '';
$rolId  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim((string) ($_POST['nombre'] ?? ''));
    $email  = trim((string) ($_POST['email'] ?? ''));
    $rolId  = (string) ($_POST['rol_id'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $token    = (string) ($_POST['g-recaptcha-response'] ?? '');

    if (! verificar_recaptcha($token)) {
        $error = 'Confirma que no eres un robot.';
    } elseif ($nombre === '' || strlen($nombre) < 3) {
        $error = 'El nombre debe tener al menos 3 caracteres.';
    } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo no es válido.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($rolId === '') {
        $error = 'Selecciona un rol.';
    } else {
        $existe = $pdo->prepare('SELECT id FROM Usuarios WHERE email = :email LIMIT 1');
        $existe->execute(['email' => $email]);

        if ($existe->fetch()) {
            $error = 'Ya existe un usuario con ese correo.';
        } else {
            $insertar = $pdo->prepare(
                'INSERT INTO Usuarios (nombre, email, password_hash, rol_id, created_at)
                 VALUES (:nombre, :email, :password_hash, :rol_id, NOW())'
            );
            $insertar->execute([
                'nombre'        => $nombre,
                'email'         => $email,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'rol_id'        => $rolId,
            ]);

            $exito  = 'Usuario creado correctamente. Ya puedes iniciar sesión.';
            $nombre = '';
            $email  = '';
            $rolId  = '';
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear usuario · Consulta pública con captcha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php if (recaptcha_configurado()): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
    <style>
        body { background: #eef1f6; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: system-ui, sans-serif; padding: 24px 0; }
        .card { max-width: 460px; width: 100%; border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.08); }
        .badge-modulo { font-size: .72rem; letter-spacing: .04em; }
    </style>
</head>
<body>
    <div class="card p-4 p-md-5">
        <span class="badge bg-primary-subtle text-primary badge-modulo mb-3">MÓDULO INDEPENDIENTE · CONSULTA PÚBLICA CON CAPTCHA</span>
        <h1 class="h3 mb-1">Crear usuario</h1>
        <p class="text-muted mb-4">Se guarda directamente en la base de datos de GOTA.</p>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= esc($error) ?></div>
        <?php endif; ?>
        <?php if ($exito): ?>
            <div class="alert alert-success py-2"><?= esc($exito) ?></div>
        <?php endif; ?>
        <?php if (! recaptcha_configurado()): ?>
            <div class="alert alert-warning py-2">
                Las llaves de reCAPTCHA no están configuradas en el <code>.env</code> de este módulo,
                así que la verificación se omite por ahora.
            </div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="mb-3">
                <label class="form-label" for="nombre">Nombre completo</label>
                <input id="nombre" type="text" name="nombre" class="form-control" value="<?= esc($nombre) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Correo</label>
                <input id="email" type="email" name="email" class="form-control" value="<?= esc($email) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Contraseña</label>
                <input id="password" type="password" name="password" class="form-control" minlength="6" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="rol_id">Rol</label>
                <select id="rol_id" name="rol_id" class="form-select" required>
                    <option value="" disabled <?= $rolId === '' ? 'selected' : '' ?>>Selecciona un rol</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= esc((string) $rol['id']) ?>" <?= (string) $rolId === (string) $rol['id'] ? 'selected' : '' ?>>
                            <?= esc($rol['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (recaptcha_configurado()): ?>
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="<?= esc(recaptcha_site_key()) ?>"></div>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">Crear usuario</button>
        </form>

        <p class="text-center text-muted small mt-4 mb-0">
            <a href="login.php">Volver al inicio de sesión</a>
        </p>
    </div>
</body>
</html>
