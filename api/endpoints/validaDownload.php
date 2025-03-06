<?php
header("Content-Type: application/json");

// Obtém o JSON enviado
$data = json_decode(file_get_contents("php://input"), true);

$fileId = $data['id'];
$filePath = $data['path'];

echo json_encode($filePath);
exit;

if (file_exists($filePath)) {
    // Permite o download do arquivo
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    readfile($filePath);
    exit;
} else {
    // Retorna erro caso o arquivo não seja encontrado
    echo json_encode(["error" => "Arquivo não encontrado."]);
}

?>