<?php

declare(strict_types=1);

function google_play_access_token(): string
{
    if (!is_file(SERVICE_ACCOUNT_PATH)) {
        throw new RuntimeException('Arquivo service-account.json não encontrado.');
    }

    $account = json_decode((string) file_get_contents(SERVICE_ACCOUNT_PATH), true);

    if (!is_array($account) || ($account['type'] ?? '') !== 'service_account') {
        throw new RuntimeException('service-account.json inválido.');
    }

    $email = (string) ($account['client_email'] ?? '');
    $privateKey = (string) ($account['private_key'] ?? '');
    $tokenUri = (string) ($account['token_uri'] ?? 'https://oauth2.googleapis.com/token');

    if ($email === '' || $privateKey === '') {
        throw new RuntimeException('service-account.json sem client_email ou private_key.');
    }

    $now = time();
    $payload = [
        'iss' => $email,
        'scope' => 'https://www.googleapis.com/auth/admin.directory.group.member',
        'aud' => $tokenUri,
        'iat' => $now,
        'exp' => $now + 3600,
    ];

    if (GOOGLE_WORKSPACE_ADMIN !== '') {
        $payload['sub'] = GOOGLE_WORKSPACE_ADMIN;
    }

    $header = google_play_b64url(json_encode(['alg' => 'RS256', 'typ' => 'JWT'], JSON_THROW_ON_ERROR));
    $claims = google_play_b64url(json_encode($payload, JSON_THROW_ON_ERROR));

    $unsigned = $header . '.' . $claims;
    $ok = openssl_sign($unsigned, $signature, $privateKey, OPENSSL_ALGO_SHA256);

    if ($ok !== true || !is_string($signature) || $signature === '') {
        throw new RuntimeException('Não foi possível assinar o JWT da service account.');
    }

    $jwt = $unsigned . '.' . google_play_b64url($signature);
    $response = google_play_http('POST', $tokenUri, [
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion' => $jwt,
    ], [
        'Content-Type: application/x-www-form-urlencoded',
    ]);

    $accessToken = $response['access_token'] ?? null;

    if (!is_string($accessToken) || $accessToken === '') {
        throw new RuntimeException('A Google não devolveu um access token.');
    }

    return $accessToken;
}

function google_play_add_tester(string $email): bool
{
    if (GOOGLE_WORKSPACE_GROUP === '') {
        throw new RuntimeException('GOOGLE_WORKSPACE_GROUP não está configurado.');
    }

    $token = google_play_access_token();
    $alreadyMember = google_play_add_group_member($token, $email);
    google_play_wait_for_member($token, $email);

    return $alreadyMember;
}

function google_play_add_group_member(string $token, string $email): bool
{
    $result = google_play_http(
        'POST',
        'https://admin.googleapis.com/admin/directory/v1/groups/' . rawurlencode(GOOGLE_WORKSPACE_GROUP) . '/members',
        [
            'email' => $email,
            'role' => 'MEMBER',
            'type' => 'USER',
        ],
        [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ],
        false
    );

    $status = (int) ($result['_http_status'] ?? 0);

    if ($status === 409) {
        return true;
    }

    if ($status === 200 || $status === 201) {
        return false;
    }

    $message = $result['error']['message'] ?? $result['error_description'] ?? ('HTTP ' . $status);
    throw new RuntimeException(is_string($message) ? $message : 'Erro ao adicionar testador no Google Group.');
}

function google_play_member_is_active(string $token, string $email): bool
{
    $result = google_play_http(
        'GET',
        'https://admin.googleapis.com/admin/directory/v1/groups/'
            . rawurlencode(GOOGLE_WORKSPACE_GROUP)
            . '/members/'
            . rawurlencode($email),
        null,
        [
            'Authorization: Bearer ' . $token,
        ],
        false
    );

    $status = (int) ($result['_http_status'] ?? 0);
    $memberStatus = strtoupper((string) ($result['status'] ?? ''));

    return $status === 200 && ($memberStatus === '' || $memberStatus === 'ACTIVE');
}

function google_play_wait_for_member(string $token, string $email, int $tries = 8): void
{
    for ($i = 0; $i < $tries; $i++) {
        if (google_play_member_is_active($token, $email)) {
            return;
        }

        sleep(1);
    }

    throw new RuntimeException('O Google Group ainda não confirmou o e-mail como membro ativo. Tente de novo em alguns segundos.');
}

/**
 * @param array<string, string>|object|null $body
 * @param list<string> $headers
 * @return array<string, mixed>
 */
function google_play_http(string $method, string $url, array|object|null $body, array $headers, bool $throw = true): array
{
    $payload = null;

    if (is_array($body) && in_array('Content-Type: application/x-www-form-urlencoded', $headers, true)) {
        $payload = http_build_query($body);
    } elseif ($body !== null) {
        $payload = json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    $context = stream_context_create([
        'http' => [
            'method' => $method,
            'header' => implode("\r\n", $headers),
            'content' => $payload ?? '',
            'ignore_errors' => true,
            'timeout' => 20,
        ],
    ]);

    $raw = file_get_contents($url, false, $context);

    if ($raw === false) {
        throw new RuntimeException('Falha de rede ao falar com a Google.');
    }

    $status = 0;

    foreach ($http_response_header ?? [] as $line) {
        if (preg_match('/^HTTP\/\S+\s+(\d+)/', $line, $match) === 1) {
            $status = (int) $match[1];
        }
    }

    $decoded = json_decode($raw, true);
    $data = is_array($decoded) ? $decoded : ['raw' => $raw];
    $data['_http_status'] = $status;

    if ($throw && ($status < 200 || $status >= 300)) {
        $message = $data['error']['message'] ?? $data['error_description'] ?? ('HTTP ' . $status);
        throw new RuntimeException(is_string($message) ? $message : 'Erro na API da Google.');
    }

    return $data;
}

function google_play_b64url(string $value): string
{
    return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
}
