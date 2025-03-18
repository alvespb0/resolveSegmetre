<?php
require_once 'controllerFiles.php';

use controllers\ControllerFiles;

$controllerUser = new ControllerFiles;

$teste = $controllerUser->obtainFilesByDate('2025-03-17');
var_dump($teste) ;

echo "<br> quebra de linha <br>";

$teste2 = $controllerUser->obtainFilesByDateFilteredCompany('2025-03-17', 7);
var_dump($teste2);
?>