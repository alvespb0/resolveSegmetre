<?php
require_once 'controllerOperador.php';

use controllers\ControllerOperador;

$controllerOperador = new ControllerOperador;

$teste = $controllerOperador->obtainOperador("arthur@segmetre.com.br");
var_dump($teste);
?>