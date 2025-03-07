<?php
header("Content-Type: application/json");

$url = "http://{$_SERVER['HTTP_HOST']}/api/endpoints/validaEmail.php";

$data = json_decode(file_get_contents("php://input"), true);

$ch = curl_init($url); #Inicializa o cURL com a URL de destino
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); #Permite que a resposta seja retornada
curl_setopt($ch, CURLOPT_POST, true); #define a requisição como POST
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); #Envia os dados recebidos para o destino
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]); #Informa que estamos enviando JSON

$response = curl_exec($ch); #Executa a requisição
curl_close($ch); #fecha a requisição

if (curl_errno($ch)) {
    // Em caso de erro na requisição cURL, exibe a mensagem de erro
    echo json_encode(["error" => "Erro na requisição cURL: " . curl_error($ch)]);
    curl_close($ch); // Fecha a requisição
    exit;
}

curl_close($ch); // Fecha a requisição

if (empty($response)) {
    // Se a resposta estiver vazia, informa o erro
    echo json_encode(["error" => "Resposta vazia do servidor"]);
    exit;
}

echo $response;
exit;

?>