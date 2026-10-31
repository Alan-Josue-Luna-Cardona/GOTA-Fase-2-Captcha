<?php

/**
 * Conexión directa, por PDO, a la misma base de datos que usa el monolito
 * GOTA (tablas Usuarios y Roles). Este módulo no llama a ningún endpoint
 * del monolito: lee y escribe la base de datos compartida directamente,
 * tal como se acordó para no modificar el sistema heredado.
 */

declare(strict_types=1);

function conexion_bd(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = env_local('DB_HOST', 'db');
    $puerto = env_local('DB_PORT', '3306');
    $nombre = env_local('DB_NAME', 'gota_db');
    $usuario = env_local('DB_USER', 'root');
    $password = env_local('DB_PASSWORD', '');

    $dsn = "mysql:host={$host};port={$puerto};dbname={$nombre};charset=utf8mb4";

    $pdo = new PDO($dsn, $usuario, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    return $pdo;
}
