<?php
header("Content-Type: application/json");

require_once($_SERVER['DOCUMENT_ROOT'] . '/phpMailer/phpMailer.php');

use mail\Mailer;


$postData = $_POST;
$fileData = isset($_FILES['file']) ? $_FILES['file'] : null;
$mailer = new Mailer;

$result = $mailer->enviaFinanceiro($postData, $fileData);

if($result === true){
    echo json_encode(["message" => "Email Enviado com sucesso!"]);
    exit;
}else if ($result === false){
    echo json_encode(["error" => "erro, destinatario não encontrado ou data de vencimento ausente!"]);
    exit;
}else{
    echo json_encode(["error" => "Erro ao enviar o e-mail!", "detalhe" => $result]);
}
?>