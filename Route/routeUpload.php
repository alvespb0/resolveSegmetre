<?php
require_once '../Seguranca/origemSegura.php';

header("Content-Type: application/json");

// Verifica se o arquivo foi enviado

if (!isset($_FILES['file']) || !isset($_POST['company_id']) || !isset($_POST['file_name']) || !isset($_POST['upload_date'])) {
    echo json_encode(["error" => "Campos obrigatórios faltantes."]);
    exit;
}

switch ($_FILES['file']['error']) {
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
        echo json_encode(["error" => "O arquivo enviado é muito grande. O tamanho máximo permitido é 20MB."]);
        exit;

    case UPLOAD_ERR_PARTIAL:
        echo json_encode(["error" => "O upload do arquivo não foi concluído. Tente novamente."]);
        exit;

    case UPLOAD_ERR_NO_FILE:
        echo json_encode(["error" => "Nenhum arquivo foi enviado."]);
        exit;
}

// Define a URL correta
$url = "https://{$_SERVER['HTTP_HOST']}/api/endpoints/validaUpload.php";

// Dados para enviar no cURL
$data = [
    'company_id' => $_POST['company_id'],
    'file_name' => $_POST['file_name'],
    'upload_date' => $_POST['upload_date'],
    'operadorId' => $_POST['OperadorId'],
    'file' => new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name'])
];

// Inicializa cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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
    echo json_encode(["error" => "Falha ao acessar validaUpload.php, código HTTP: " . $httpCode]);
    exit;
}

// Se a resposta estiver vazia, algo deu errado
if (empty($response)) {
    echo json_encode(["error" => "Resposta vazia do servidor"]);
    exit;
}

// Retorna a resposta da API
echo $response;
?>
