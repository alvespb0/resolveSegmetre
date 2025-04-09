<?php
require_once('../../Controller/controllerUsuario.php');

use controllers\ControllerUsuario;

header("Content-Type: application/json"); #isso básicamente define que o conteúdo da resposta será em JSON

$data = json_decode(file_get_contents("php://input"), true); #Lê os dados do JSON recebido e converte em ARRAY

if (!isset($data['token']) || !isset($data['senha'])) {
    echo json_encode(["error" => "Dados incompletos. Token e senha são obrigatórios."]);
    exit;
}

$token = $data['token'];

$senha = $data['senha'];

$controllerUsuario = new ControllerUsuario;

if($controllerUsuario->alterarSenha($token, $senha)){
    if($controllerUsuario->invalidaTokenSenha($token)){
        echo json_encode(["message" => "Senha alterada com sucesso!"]);
        exit;
    }else{
        error_log("Erro ao inativar token mas senha alterada com sucesso");
        echo json_encode(["message" => "Usuario cadastrado com sucesso"]);
        exit;
    }
}else{
    echo json_encode(["error" => "Erro ao alterar a senha do Usuario"]);
    exit;
}
?>