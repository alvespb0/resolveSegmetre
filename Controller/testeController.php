<?php
require_once 'controllerUsuario.php';

use controllers\ControllerUsuario;

$controllerUser = new ControllerUsuario;

$teste = $controllerUser->getUserNameByIdCompany(1);
var_dump($teste) ;
?>