<?php

header("Content-Type: application/json");

// Pegando os dados do POST (campos do formulário)
$postData = $_POST;

// Pegando os dados do arquivo enviado
$fileData = isset($_FILES['file']) ? $_FILES['file'] : null;

// Retornando os dados para debug
echo json_encode([
    "post" => $postData,
    "file" => $fileData
]);

?>