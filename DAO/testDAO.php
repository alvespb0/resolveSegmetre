<?php
require 'daoUsuario.php';
use DAO\DAOusuario;

$daoUser = new DAOusuario;

$daoUser->deleteUsuarioById(11);
?>