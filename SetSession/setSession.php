<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if($data['userName'] === 'MedSegmetre'){
        $data['type'] = 'medico';
    }
    if($data['type'] === 'operador'){
        if($data['setor'] === 'recepcao'){
            $_SESSION['userName'] = $data['userName'];
            $_SESSION['type'] = $data['setor'];
            $_SESSION['idOperador'] = $data['operadorId'];
            $_SESSION['empresaId'] = null;
            echo json_encode(["success" => true, "type" => $_SESSION['type']]);
        }else if($data['setor'] === 'financeiro'){
            $_SESSION['userName'] = $data['userName'];
            $_SESSION['type'] = $data['setor'];
            $_SESSION['empresaId'] = null;
            echo json_encode(["success" => true, "type" => $_SESSION['type']]);
        }else if($data['setor'] === 'admin'){
            $_SESSION['userName'] = $data['userName'];
            $_SESSION['type'] = $data['setor'];
            $_SESSION['idOperador'] = $data['operadorId'];
            $_SESSION['empresaId'] = null;
            echo json_encode(["success" => true, "type" => $_SESSION['type']]);    
        }
    }else if($data['type'] === 'usuario'){
        $_SESSION['userName'] = $data['userName'];
        $_SESSION['type'] = $data['type'];
        $_SESSION['empresaId'] = $data['empresaId'];
        echo json_encode(["success" => true, "type" => $data['type']]);
    }else if($data['type'] === 'medico'){
        $_SESSION['userName'] = $data['userName'];
        $_SESSION['type'] = $data['type'];
        $_SESSION['idOperador'] = $data['operadorId'];
        $_SESSION['empresaId'] = null;
        echo json_encode(["success" => true, "type" => $data['type']]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Dados inválidos"]);
}
?>




