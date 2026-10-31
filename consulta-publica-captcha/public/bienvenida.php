<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenida · Consulta pública con captcha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eef1f6; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: system-ui, sans-serif; }
        .card { max-width: 420px; width: 100%; border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.08); }
    </style>
</head>
<body>
    <div class="card p-4 p-md-5 text-center">
        <div class="display-6 mb-3">✅</div>
        <h1 class="h4">Bienvenido, <?= esc($usuario['nombre']) ?></h1>
        <p class="text-muted mb-1"><?= esc($usuario['email']) ?></p>
        <p class="text-muted mb-4">Rol: <?= esc($usuario['rol']) ?></p>
        <p class="small text-muted">
            Esta pantalla solo confirma que el login (protegido con captcha) funcionó
            contra la base de datos real de GOTA. El resto de la operación de la
            Oficina del Agua sigue viviendo en el monolito.
        </p>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm mt-2">Cerrar sesión</a>
    </div>
</body>
</html>
