<?php
require_once '../../Controller/controllerUsuario.php';
use controllers\ControllerUsuario;

header("Content-Type: application/json");

// Obtém o JSON enviado
$data = json_decode(file_get_contents("php://input"), true);

$companyId = $data['company_id'];

$controllerUsuario = new ControllerUsuario;

if($controllerUsuario->sendEmail($companyId)){
    echo json_encode(["message" => "Email Enviado com sucesso!"]);
    exit;
}else{
    echo json_encode(["error" => "Erro ao enviar o email!"]);
    exit;
}

?>