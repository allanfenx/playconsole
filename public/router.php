<?php

declare(strict_types=1);

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

switch ($uri) {
    case '/google':
        require __DIR__ . '/google.php';
        return true;
    case '/politica-de-privacidade':
    case '/politica-de-privacidade.html':
        require __DIR__ . '/politica-de-privacidade.php';
        return true;
    case '/robots.txt':
        require __DIR__ . '/robots.php';
        return true;
    case '/sitemap.xml':
        require __DIR__ . '/sitemap.php';
        return true;
    case '/':
    case '/index.php':
        require __DIR__ . '/index.php';
        return true;
}

$publicFile = __DIR__ . $uri;

if ($uri !== '/' && is_file($publicFile)) {
    return false;
}

http_response_code(404);
header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Página não encontrada</title></head><body><h1>Página não encontrada</h1><p><a href="/">Voltar ao Driver Finances</a></p></body></html>';
return true;
