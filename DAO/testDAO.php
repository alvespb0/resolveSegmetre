<?php
require 'daoFiles.php';
use DAO\DAOfiles;

$dao = new DAOfiles;

$file = $dao->getFileByIndex(62);
echo $file['file_path'];
?>