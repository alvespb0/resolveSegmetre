<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['senha']) || !isset($data['type'])) {
    echo json_encode(["error" => "Campos obrigatórios faltantes."]);
    exit;
}else{
    // Define a URL correta
    $url = "http://{$_SERVER['HTTP_HOST']}/api/auth/validaLogin.php";

    // Inicializa cURL
    $ch = curl_init($url);
curl_setopt($ch, CURLOPT_PROXY, "");
    curl_setopt($ch, CURLOPT_NOPROXY, "localhost,127.0.0.1");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

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
        echo json_encode(["error" => "Falha ao acessar validaLogin.php, código HTTP: " . $httpCode, "URL:" => $url]);
        exit;
    }

    // Se a resposta estiver vazia, algo deu errado
    if (empty($response)) {
        echo json_encode(["error" => "Resposta vazia do servidor"]);
        exit;
    }

    // Retorna a resposta da API
    echo $response;
}
?>
