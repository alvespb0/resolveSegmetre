<?php
require_once('../../Controller/controllerOperador.php');
require_once('../../Controller/controllerUsuario.php');

use controllers\ControllerOperador;
use controllers\ControllerUsuario;

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['senha']) || !isset($data['type'])) {
    echo json_encode(["error" => "Campos obrigatórios"]);
    exit;
}else{
    $email = $data['email'];
    $password = $data['senha'];
    $type = $data['type'];

    if($type === 'usuario'){
        $controllerUsuario = new ControllerUsuario;
        $usuario = $controllerUsuario->obtainUsuario($email);
        if(is_array($usuario)){
            if($usuario['email'] && password_verify($password, $usuario['password_hash'])){

                echo json_encode(["message" => "Login Efetuado!",
                                  "userName" => $usuario['name'],
                                  "empresaId" => $usuario['company_id'],
                                  "type" => "usuario"]);
            }else{
                echo json_encode(["error" => "Login e/ou senha incorreta!"]); // ele valida que é uma array então existe usuario com esse email, mas a senha está errada
            }
        }else{
            echo json_encode(["error" => "Login de Usuário não encontrado em nosso sistema"]); // se $usuario não é uma array, ele caiu na segunda condicional da controller então não achou nada no banco
        }
    }else if($type === 'operador'){
        $controllerOperador = new ControllerOperador;
        $operador = $controllerOperador->obtainOperador($email);
        if(is_array($operador)){
            if($operador && password_verify($password, $operador['password_hash'])){
                echo json_encode(["message" => "Login Efetuado!",
                                  "userName" => $operador['name'],
                                  "operadorId" => $operador['id'],
                                  "empresaId" => null,
                                  "type" => "operador"]);
            }else{
                echo json_encode(["error" => "Login e/ou senha incorreta!"]); // ele valida que é uma array então existe usuario com esse email, mas a senha está errada
            }
        }else{
            echo json_encode(["error" => "Login de Operador não encontrado em nosso sistema"]); // se $operador não é uma array, ele caiu na segunda condicional da controller então não achou nada no banco
        }
    }else{
        echo json_encode(["error" => "Tens de selecionar Usuário ou Operador"]);
    }

}


?>
