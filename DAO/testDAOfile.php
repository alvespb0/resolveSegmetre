<?php
require_once 'daoUsuario.php';

use DAO\DAOusuario;



$dao = new DAOusuario;

$resultado = $dao->getIdCompany();

foreach ($resultado as $name => $company_id) {
    echo "Nome da Empresa: " . $name . " | ID da Empresa: " . $company_id . "<br>";
}

?>