<?php
require_once('../../Controller/controllerUsuario.php');

use controllers\ControllerUsuario;

header("Content-Type: application/json"); #isso básicamente define que o conteúdo da resposta será em JSON

$data = json_decode(file_get_contents("php://input"), true); #Lê os dados do JSON recebido e converte em ARRAY

if (!isset($data['usuario']) || !isset($data['email']) || !isset($data['senha']) || !isset($data['cnpj'])) {
    echo json_encode(["error" => "Campos obrigatórios: name, email, password, cnpj"]);
    exit;
}else{
    $controllerUsuario = new ControllerUsuario;

    $return = $controllerUsuario->createUsuario($data);

    if($return){
        if(isset($data['token'])){
            $retorno = $controllerUsuario->invalidaToken($data['token']);
            if($retorno == true){
                echo json_encode(["message" => "Usuario cadastrado com sucesso"]);
                exit;
            }else{
                error_log("Erro ao inativar token mas cadastro concluido com sucesso");
                echo json_encode(["message" => "Usuario cadastrado com sucesso"]);
                exit;
            }
        }else{
            echo json_encode(["message" => "Usuario cadastrado com sucesso"]);
            exit;
        }
        
    }else{
        echo json_encode(["error" => "Erro ao cadastrar o Usuario"]);
        exit;
    }
}

?>