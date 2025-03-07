<?php
require('../../Controller/controllerFiles.php');
require('../../Controller/controllerUsuario.php');

use controllers\ControllerFiles;
use controllers\ControllerUsuario;

header("Content-Type: application/json");

$postData = $_POST;

// Pegando os dados do arquivo enviado
$fileData = isset($_FILES['file']) ? $_FILES['file'] : null;

$path = __DIR__ . "/../uploads/" . $postData['company_id']; // Define o caminho da pasta baseado na company_id

if (!is_dir($path)) { #Verifica se a pasta não existe

    if (mkdir($path, 0755, true)) { 
        #entra nessa condição se a pasta foi criada com sucesso
        $destination = $path . "/" . basename($fileData['name']);
        if (move_uploaded_file($fileData['tmp_name'], $destination)) {
            #entra nessa condição se conseguiu mover o arquivo para a path
            $destination = str_replace("\\", "/", $destination);

            $controllerFiles = new ControllerFiles;
            $return = $controllerFiles->createFile($postData, $destination);
            if($return){
                echo json_encode([
                    "message" => "Arquivo enviado com sucesso!",
                    "file_path" => $destination,
                    "company_id" => $postData['company_id']
                ]);
                exit;            
            }else{
                echo json_encode([
                    "message" => "Erro ao enviar o arquivo!",
                    "file_path" => $destination
                ]);
            }
        } else {
            #entra nessa condição se não conseguiu mover o arquivo para a path
            echo json_encode(["error" => "Falha ao mover o arquivo para a pasta de destino."]);
        }        

    } else {
        #entra nessa condição se não foi possível criar a pasta do cliente
        echo json_encode(["error" => "Erro ao criar a pasta do cliente"]);
        exit;
    }
} else {
    #entra nessa condição se a path existe
    $destination = $path . "/" . basename($fileData['name']);
    if (move_uploaded_file($fileData['tmp_name'], $destination)) {
        $destination = str_replace("\\", "/", $destination);

        $controllerFiles = new ControllerFiles;
        $return = $controllerFiles->createFile($postData, $destination);
        if($return){
            echo json_encode([
                "message" => "Arquivo enviado com sucesso!",
                "file_path" => $destination,
                "company_id" => $postData['company_id']
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