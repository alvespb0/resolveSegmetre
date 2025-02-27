<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/DAO/DAOUsuario.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/empresa.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/usuario.php');

use models\Empresa;
use models\Usuario;
use DAO\DAOusuario;

/* $empresa = new Empresa;
$empresa->CNPJEmpresa = 123456789;

$usuario = new Usuario;
$usuario->nomeFuncionario = "arthur";
$usuario->emailUsuario = "arthur1@gmail";
$usuario->senhaUsuario = "123456";
 */
$daoUsuario = new DAOusuario;

$teste = $daoUsuario->getUsuario("adami@postmaster");
var_dump($teste);
?>