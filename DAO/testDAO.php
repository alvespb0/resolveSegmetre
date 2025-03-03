<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/DAO/daoFiles.php');
use DAO\DAOfiles;

$dao = new DAOfiles;

$return = $dao->getFilesById(12);

print_r($return);
?>