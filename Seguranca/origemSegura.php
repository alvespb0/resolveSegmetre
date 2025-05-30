<?php
$allowedOrigins = [
    'https://resolvesegmetre.com.br',
    'http://localhost',
    'https://localhost',
    'https://resolvesegmetre.com.br:1443',
    'https://teste.resolvesegmetre.com.br:1443',
    'https://teste.resolvesegmetre.com.br'
];

if (!isset($_SERVER['HTTP_ORIGIN']) || !in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    http_response_code(403);
    echo json_encode(['error' => 'Origem não autorizada']);
    exit;
}
?>