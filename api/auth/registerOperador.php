<?php
require '../config/database.php';

header("Content-Type: application/json"); #isso básicamente define que o conteúdo da resposta será em JSON

$data = json_decode(file_get_contents("php://input"), true); #Lê os dados do JSON recebido e converte em ARRAY

if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["error" => "Campos obrigatórios: name, email, password"]);
    exit;
}else{
    $name = $data['name'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT); #Isto é apenas para usar o HASH para salvar de forma encriptada

    try{
        $conn = new \MySQLi($host, $username, "", $dbname); #Inicia conexão com o banco
        $sqlInsert = $conn->prepare("INSERT INTO operators ('name', email, password_hash) VALUES (?, ?, ?)");
        $sqlInsert->bind_param("sss", $name, $email, $password);
        $sqlInsert->execute();

        if(!$sqlInsert->error){
            echo json_encode(["message" => "Operador cadastrado com sucesso"]);
        }else{
            echo json_encode(["error" => "Erro ao cadastrar operador"]);
        }
    }catch(\Exception $e){
        die($e->getMessage());
    }
    

}

?>