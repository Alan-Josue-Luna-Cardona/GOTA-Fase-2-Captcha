<?php

/**
 * Cargador mínimo de archivos .env, sin dependencias de Composer.
 * Lee KEY=VALUE por línea, ignora comentarios (#) y líneas vacías,
 * y expone los valores con getenv_local().
 */

function cargar_env(string $ruta): void
{
    static $cargado = false;

    if ($cargado || ! is_file($ruta)) {
        return;
    }

    foreach (file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
        $linea = trim($linea);

        if ($linea === '' || str_starts_with($linea, '#')) {
            continue;
        }

        if (! str_contains($linea, '=')) {
            continue;
        }

        [$clave, $valor] = explode('=', $linea, 2);
        $clave = trim($clave);
        $valor = trim($valor);
        $valor = trim($valor, "\"'");

        if ($clave !== '' && getenv($clave) === false) {
            putenv("{$clave}={$valor}");
            $_ENV[$clave] = $valor;
        }
    }

    $cargado = true;
}

function env_local(string $clave, string $porDefecto = ''): string
{
    $valor = getenv($clave);

    return $valor === false ? $porDefecto : $valor;
}
