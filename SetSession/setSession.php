<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if($data['type'] === 'operador'){
        $_SESSION['userName'] = $data['userName'];
        $_SESSION['type'] = $data['type'];
        $_SESSION['idOperador'] = $data['operadorId'];
        $_SESSION['empresaId'] = null;
        echo json_encode(["success" => true]);
    }else if($data['type'] === 'usuario'){
        $_SESSION['userName'] = $data['userName'];
        $_SESSION['userType'] = $data['type'];
        $_SESSION['empresaId'] = $data['empresaId'];
        echo json_encode(["success" => true]);
    }
    } else {
        echo json_encode(["success" => false, "error" => "Dados inválidos"]);
    }
?>




