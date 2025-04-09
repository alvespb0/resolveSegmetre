<?php
require_once '../Seguranca/origemSegura.php';

header("Content-Type: application/json"); #isso básicamente define que o conteúdo da resposta será em JSON

$data = json_decode(file_get_contents("php://input"), true); #Recebe os dados via POST e converte JSON para um array

if (!isset($data['type']) || !isset($data['usuario']) || !isset($data['senha'])) { #Verifica se todos os campos do formulário estão preenchidos
    echo json_encode(["error" => "Campos obrigatorios faltantes."]);
    exit;
}else{
    $type = $data['type'];
    if ($type === 'operador') {
        $url = "https://{$_SERVER['HTTP_HOST']}/api/auth/registerOperador.php";
        
    } elseif ($type === 'usuario') {
        $url = "https://{$_SERVER['HTTP_HOST']}/api/auth/registerUsuario.php";
    } elseif($type === 'financeiro'){
        $url = "https://{$_SERVER['HTTP_HOST']}/api/auth/registerFinanceiro.php";
    }else {
        echo json_encode(["error" => "Tipo inválido"]);
        exit;
    }
    /* Fazendo requisição para o arquivo correto */
    $ch = curl_init($url); #Inicializa o cURL com a URL de destino
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); #Permite que a resposta seja retornada
    curl_setopt($ch, CURLOPT_POST, true); #define a requisição como POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); #Envia os dados recebidos para o destino
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]); #Informa que estamos enviando JSON

    $response = curl_exec($ch); #Executa a requisição
    curl_close($ch); #fecha a requisição
    if (curl_errno($ch)) {
        echo json_encode(["error" => "Erro na requisição cURL: " . curl_error($ch)]);
        curl_close($ch);
        exit;
    }
    if (empty($response)) {
        echo json_encode(["error" => "Resposta vazia do servidor"]);
        exit;
    }


    echo $response;
}


?>