<?php

/**
 * Arranque común de este módulo. Se incluye al principio de cada página pública.
 *
 * Este módulo es una aplicación PHP independiente del monolito GOTA: no
 * comparte código ni carpetas con él. Lo único que comparte es la misma
 * base de datos MySQL/MariaDB, a la que se conecta directamente por PDO
 * (ver db.php). No se modifica ni se importa ningún archivo de GOTA.
 */

declare(strict_types=1);

require_once __DIR__ . '/env.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/recaptcha.php';

// El .env real vive en la raíz de este módulo (no se versiona en git).
cargar_env(__DIR__ . '/../.env');

if (session_status() === PHP_SESSION_NONE) {
    // Nombre de sesión propio para no mezclarse con la sesión del monolito
    // si alguna vez se sirven bajo el mismo dominio.
    session_name('gota_consulta_publica');
    session_start();
}

function esc(?string $valor): string
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
