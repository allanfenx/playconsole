<?php

declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/google_play.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$raw = file_get_contents('php://input') ?: '';
$payload = json_decode($raw, true);

if (!is_array($payload)) {
    $payload = $_POST;
}

$email = strtolower(trim((string) ($payload['email'] ?? '')));

if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    http_response_code(400);
    echo json_encode(['error' => 'Informe um e-mail válido.'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match('/@gmail\.com$/i', $email)) {
    http_response_code(400);
    echo json_encode(
        ['error' => 'Aceitamos apenas endereços @gmail.com, porque é uma exigência do sistema de testes do Google.'],
        JSON_UNESCAPED_UNICODE
    );
    exit;
}

try {
    $alreadyMember = google_play_add_tester($email);
} catch (Throwable $exception) {
    http_response_code(502);
    echo json_encode(['error' => $exception->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($alreadyMember) {
    http_response_code(409);
    echo json_encode(['error' => 'Email already exists'], JSON_UNESCAPED_UNICODE);
    exit;
}

http_response_code(201);
echo json_encode(['message' => 'E-mail enviado ao Google Group.'], JSON_UNESCAPED_UNICODE);
