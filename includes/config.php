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
    $configured = rtrim(env('SITE_URL', ''), '/');

    if ($configured !== '') {
        $base = $configured;
    } else {
        $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? 'localhost:8080'));
        $hostOnly = preg_replace('/:\d+$/', '', $host) ?? $host;

        if ($hostOnly === 'app.tecnofenx.com.br' || $hostOnly === 'www.app.tecnofenx.com.br') {
            $base = 'https://app.tecnofenx.com.br';
        } else {
            $forwarded = strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));
            $https = $forwarded === 'https'
                || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                || (string) ($_SERVER['SERVER_PORT'] ?? '') === '443';
            $scheme = $https ? 'https' : 'http';
            $base = $scheme . '://' . $host;
        }
    }

    $normalized = '/' . ltrim($path, '/');

    if ($normalized === '/') {
        return $base . '/';
    }

    return $base . $normalized;
}

function request_is_https(): bool
{
    $forwarded = strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));

    return $forwarded === 'https'
        || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (string) ($_SERVER['SERVER_PORT'] ?? '') === '443';
}

function enforce_canonical_request(): void
{
    if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
        return;
    }

    $method = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));

    if ($method !== 'GET' && $method !== 'HEAD') {
        return;
    }

    $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
    $hostOnly = preg_replace('/:\d+$/', '', $host) ?? $host;

    if ($hostOnly !== 'app.tecnofenx.com.br' && $hostOnly !== 'www.app.tecnofenx.com.br') {
        return;
    }

    $requestUri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
    $path = parse_url($requestUri, PHP_URL_PATH) ?: '/';
    $theRequest = (string) ($_SERVER['THE_REQUEST'] ?? '');

    if (preg_match('#^[A-Z]+\s+([^?\s]+)#', $theRequest, $matches) === 1) {
        $path = rawurldecode($matches[1]);
    }

    $query = parse_url($requestUri, PHP_URL_QUERY);
    $targetPath = match ($path) {
        '/index.php', '/index.php/' => '/',
        '/politica-de-privacidade.php',
        '/politica-de-privacidade.html',
        '/politica-de-privacidade.php/',
        '/politica-de-privacidade.html/' => '/politica-de-privacidade',
        default => $path,
    };

    if ($hostOnly === 'app.tecnofenx.com.br' && request_is_https() && $targetPath === $path) {
        return;
    }

    $location = 'https://app.tecnofenx.com.br' . $targetPath;

    if (is_string($query) && $query !== '') {
        $location .= '?' . $query;
    }

    header('Location: ' . $location, true, 301);
    exit;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

enforce_canonical_request();
