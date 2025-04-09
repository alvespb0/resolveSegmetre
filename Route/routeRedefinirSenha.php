<?php
require_once '../Seguranca/origemSegura.php';

header("Content-Type: application/json"); #isso básicamente define que o conteúdo da resposta será em JSON

$data = json_decode(file_get_contents("php://input"), true); #Recebe os dados via POST e converte JSON para um array

if (!isset($data['senha']) || !isset($data['confirmar_senha'])){
    echo json_encode(["error" => 'Confirmação de senha faltante']);
}else{
    if($data['senha'] !== $data['confirmar_senha']){ #adiciona mais uma validação de senha
        echo json_encode(["error" => 'As senhas não coincidem']);
    }else{
        $url = "https://{$_SERVER['HTTP_HOST']}/api/auth/redefinirSenhaUser.php";
        $ch = curl_init($url); #Inicializa o cURL com a URL de destino
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); #Permite que a resposta seja retornada
        curl_setopt($ch, CURLOPT_POST, true); #define a requisição como POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); #Envia os dados recebidos para o destino
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]); #Informa que estamos enviando JSON
    
        $response = curl_exec($ch); #Executa a requisição

        if (curl_errno($ch)) {
            echo json_encode(["error" => "Erro na requisição cURL: " . curl_error($ch)]);
            curl_close($ch);
            exit;
        }
        if (empty($response)) {
            echo json_encode(["error" => "Resposta vazia do servidor"]);
            exit;
        }
        curl_close($ch); #fecha a requisição
        echo $response;
    }

}
?>