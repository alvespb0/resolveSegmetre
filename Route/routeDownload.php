<?php
require_once '../Seguranca/origemSegura.php';

// Obtém o JSON enviado
$data = json_decode(file_get_contents("php://input"), true);

// Verifica se recebeu o ID e o caminho do arquivo
if (!isset($data['id']) || !isset($data['path'])) {
    echo json_encode(["error" => "ID ou caminho do arquivo não enviados."]);
    exit;
}

$fileId = $data['id'];
$filePath = $data['path'];

// Define a URL correta para validaDownload.php
$url = "https://{$_SERVER['HTTP_HOST']}/api/endpoints/validaDownload.php";

// Configuração do cURL para enviar ID e path para validaDownload.php
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["id" => $fileId, "path" => $filePath]));  // Envia tanto o ID quanto o path
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

// Executa a requisição cURL
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// Se houver erro no cURL, retorna erro
if ($curlError) {
    echo json_encode(["error" => "Erro na requisição cURL: " . $curlError]);
    exit;
}

// Se o HTTP Code não for 200, algo deu errado no destino
if ($httpCode !== 200) {
    echo json_encode(["error" => "Falha ao acessar validaDownload.php, código HTTP: " . $httpCode]);
    exit;
}

// Se a resposta estiver vazia, algo deu errado
if (empty($response)) {
    echo json_encode(["error" => "Resposta vazia do servidor"]);
    exit;
}

// Se a resposta for válida (não erro), retorna a resposta do arquivo
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
readfile($filePath);
exit;
?>
