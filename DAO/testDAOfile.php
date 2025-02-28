<?php
require_once 'daoFiles.php';
require_once '../Model/files.php';

use models\Files;
use DAO\DAOfiles;

$file = new files;
$file->nameFile = "teste";
$file->filePath = "teste/teste";
$file->dataUpload = "16/10/2005";
$file->userId = 16;
$file->companyId = 11;

$dao = new DAOfiles;

$dao->addFile($file);

?>