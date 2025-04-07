<?php
header("Content-Type: application/json");


if(!isset($_FILES['file']) || !isset($_POST['email']) || !isset($_POST['dataVenc'])){
    #echo json_encode(["error" => "Campos obrigatórios faltantes."]);
    echo json_encode(["error" => $_FILES]);

    exit;
}

$url = "https://{$_SERVER['HTTP_HOST']}/api/endpoints/validaFinanceiro.php";

$data = [
    'email' => $_POST['email'],
    'dataVenc' => $_POST['dataVenc'],
    'files' => [] // array de caminhos dos arquivos salvos
];

foreach ($_FILES['file']['name'] as $index => $name) {
    if ($_FILES['file']['error'][$index] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['file']['tmp_name'][$index];
        $type = $_FILES['file']['type'][$index];

        $data["file[$index]"] = new CURLFile($tmpName, $type, $name);
    }
}

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
    echo json_encode(["error" => "Falha ao acessar validaFinanceiro.php, código HTTP: " . $httpCode]);
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