<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['userName'], $data['type'])) {
        $_SESSION['userName'] = $data['userName'];
        $_SESSION['userType'] = $data['type']; // Novo campo para armazenar o tipo

        if (isset($data['empresaId']) && !is_null($data['empresaId'])) {
            $_SESSION['empresaId'] = $data['empresaId'];
        } else {
            $_SESSION['empresaId'] = null;
        }

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Dados inválidos"]);
    }
}
?>
