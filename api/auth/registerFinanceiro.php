<?php
require_once('../../Controller/controllerFinanceiro.php');

use controllers\ControllerFinanceiro;

header("Content-Type: application/json"); #isso básicamente define que o conteúdo da resposta será em JSON

$data = json_decode(file_get_contents("php://input"), true); #Lê os dados do JSON recebido e converte em ARRAY
if (!isset($data['usuario']) || !isset($data['email']) || !isset($data['senha'])) {
    echo json_encode(["error" => "Campos obrigatórios: name, email, password"]);
    exit;
}else{
    $controllerFinanceiro = new ControllerFinanceiro;

    $return = $controllerFinanceiro->createOperadorFinanceiro($data);
    if($return){
        echo json_encode(["message" => "Operador Financeiro cadastrado com sucesso"]);
        exit;
    }else{
        echo json_encode(["error" => "Erro ao cadastrar operador"]);
        exit;
    }
}

?>