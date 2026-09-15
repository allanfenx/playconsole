<?php

declare(strict_types=1);

load_env(dirname(__DIR__) . '/.env');

define('PLAY_STORE_URL', env('PLAY_STORE_URL', 'https://play.google.com/store/apps/details?id=com.allanfenx.finance&hl=pt_BR'));
define('TESTER_URL', env('TESTER_URL', 'https://play.google.com/apps/testing/com.allanfenx.finance'));
define('FACEBOOK_URL', env('FACEBOOK_URL', 'https://www.facebook.com/driverfinances'));
define('GA_MEASUREMENT_ID', env('GA_MEASUREMENT_ID', 'G-7BR1Y2KXDN'));
define('ADS_ID', env('ADS_ID', 'AW-18395689746'));
define('GOOGLE_SITE_VERIFICATION', env('GOOGLE_SITE_VERIFICATION', 'dW2pdTJHtWWf_OBPzm5LMRhgoxzG6v7w4wZAVfw0Xao'));
define('STORAGE_PATH', env('STORAGE_PATH', dirname(__DIR__) . '/storage'));
define('GOOGLE_WORKSPACE_ADMIN', env('GOOGLE_WORKSPACE_ADMIN', ''));
define('GOOGLE_WORKSPACE_GROUP', env('GOOGLE_WORKSPACE_GROUP', ''));
define('PLAY_TESTER_GROUP', env('GOOGLE_WORKSPACE_GROUP', env('PLAY_TESTER_GROUP', '')));
define('PLAY_PACKAGE_NAME', env('PLAY_PACKAGE_NAME', 'com.allanfenx.finance'));
define('PLAY_TRACK', env('PLAY_TRACK', 'alpha'));
define(
    'SERVICE_ACCOUNT_PATH',
    resolve_google_credentials_path(env('GOOGLE_CREDENTIALS_JSON', env('SERVICE_ACCOUNT_PATH', '')))
);

function load_env(string $path): void
{
    if (!is_file($path) || !is_readable($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES);

    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $trimmed = trim($line);

        if ($trimmed === '' || str_starts_with($trimmed, '#')) {
            continue;
        }

        if (!str_contains($trimmed, '=')) {
            continue;
        }

        [$name, $value] = explode('=', $trimmed, 2);
        $name = trim($name);
        $value = trim($value);

        if ($name === '') {
            continue;
        }

        if (
            (str_starts_with($value, '"') && str_ends_with($value, '"'))
            || (str_starts_with($value, "'") && str_ends_with($value, "'"))
        ) {
            $value = substr($value, 1, -1);
        }

        if (getenv($name) === false) {
            putenv($name . '=' . $value);
            $_ENV[$name] = $value;
        }
    }
}

function env(string $name, string $default = ''): string
{
    $value = getenv($name);

    if ($value === false || $value === '') {
        $value = $_ENV[$name] ?? $default;
    }

    return is_string($value) ? $value : $default;
}

function resolve_google_credentials_path(string $value): string
{
    $default = dirname(__DIR__) . '/credentials/service-account.json';

    if ($value === '' || str_starts_with($value, 'classpath:')) {
        return $default;
    }

    if (is_file($value)) {
        return $value;
    }

    $relative = dirname(__DIR__) . '/' . ltrim($value, '/');

    return is_file($relative) ? $relative : $default;
}

function site_url(string $path = ''): string
{
    $forwarded = strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));
    $https = $forwarded === 'https'
        || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (string) ($_SERVER['SERVER_PORT'] ?? '') === '443';

    $scheme = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8080';
    $normalized = '/' . ltrim($path, '/');

    if ($normalized === '/') {
        return $scheme . '://' . $host . '/';
    }

    return $scheme . '://' . $host . $normalized;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
