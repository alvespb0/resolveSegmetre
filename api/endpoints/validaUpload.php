<?php
require('../../Controller/controllerFiles.php');

use controllers\ControllerFiles;

header("Content-Type: application/json");

$postData = $_POST;

// Pegando os dados do arquivo enviado
$fileData = isset($_FILES['file']) ? $_FILES['file'] : null;

$path = __DIR__ . "/../uploads/" . $postData['company_id']; // Define o caminho da pasta baseado na company_id

if (!is_dir($path)) { // Verifica se a pasta não existe

    if (mkdir($path, 0755, true)) { 
        #entra nessa condição se a pasta foi criada com sucesso
        $destination = $path . "/" . basename($fileData['name']);
        if (move_uploaded_file($fileData['tmp_name'], $destination)) {
            $controllerFiles = new ControllerFiles;
            $controllerFiles->createFile($postData, $path);
            echo json_encode([
                "message" => "Arquivo enviado com sucesso!",
                "file_path" => $destination
            ]);
        } else {
            echo json_encode(["error" => "Falha ao mover o arquivo para a pasta de destino."]);
        }        

    } else {
        echo json_encode(["error" => "Erro ao criar a pasta do cliente"]);
        exit;
    }
} else {
 
    $destination = $path . "/" . basename($fileData['name']);

    if (move_uploaded_file($fileData['tmp_name'], $destination)) {
        $controllerFiles = new ControllerFiles;
        

        if($return){
            echo json_encode([
                "message" => "Arquivo enviado com sucesso!",
                "file_path" => $destination
            ]);
            exit;
        }else{
            echo json_encode([
                "message" => "Erro ao enviar o arquivo!",
                "file_path" => $destination
            ]);
        }
        
    } else {
        echo json_encode(["error" => "Falha ao mover o arquivo para a pasta de destino."]);
    }
    
}

?>