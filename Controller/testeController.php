<?php
require_once 'controllerUsuario.php';

use controllers\ControllerUsuario;

$controllerUser = new ControllerUsuario;

$controllerUser->sendEmail(12);
?>