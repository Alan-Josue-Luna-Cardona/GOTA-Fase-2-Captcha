<?php

/**
 * Verificación de Google reCAPTCHA v2 ("No soy un robot").
 * Hace la consulta pública al endpoint de verificación de Google
 * (https://www.google.com/recaptcha/api/siteverify) usando la clave
 * secreta del .env de este módulo. El monolito no interviene en nada
 * de esto.
 */

declare(strict_types=1);

function recaptcha_site_key(): string
{
    return env_local('RECAPTCHA_SITE_KEY', '');
}

function recaptcha_configurado(): bool
{
    return recaptcha_site_key() !== '' && env_local('RECAPTCHA_SECRET_KEY', '') !== '';
}

function verificar_recaptcha(?string $token): bool
{
    $secretKey = env_local('RECAPTCHA_SECRET_KEY', '');

    if (! recaptcha_configurado()) {
        // Sin llaves configuradas no se puede verificar; se deja constancia
        // en el log del contenedor en vez de bloquear el flujo en desarrollo.
        error_log('reCAPTCHA no está configurado: faltan RECAPTCHA_SITE_KEY y/o RECAPTCHA_SECRET_KEY en el .env');

        return true;
    }

    if ($token === null || trim($token) === '') {
        return false;
    }

    $contexto = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query([
                'secret'   => $secretKey,
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
            ]),
            'timeout' => 10,
        ],
    ]);

    $respuesta = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $contexto);

    if ($respuesta === false) {
        error_log('No se pudo contactar a reCAPTCHA (revisa la conexión de red del contenedor)');

        return false;
    }

    $resultado = json_decode($respuesta, true);

    return (bool) ($resultado['success'] ?? false);
}
