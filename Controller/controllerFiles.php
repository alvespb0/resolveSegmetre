<?php
namespace controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/DAO/daoFiles.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/files.php');

use models\Files;
use DAO\DAOfiles;

/**
 * classe responsável por fazer os tratamento de dados vindas da API (via JSON) ou envio de requests para a DAO
 * @author Arthur Alves
 */
class ControllerFiles{
    /**
     * recebe uma array vinda da API, após receber a ARRAY cria um objeto do tipo operador
     * e chama a função da DAO passando como parâmetro o objeto operador;
     * @param Array data
     * @return bool
     */
    public function createFile($data){
        $file = new Files;
        $file->nameFile = $data['nameFile'];
        $file->filePath = $data['filePath'];
        $file->dataUpload = $data['data'];
        $file->userId = $data['userId'];
        $file->companyId = $data['companyId'];

        $daoFile = new DAOfiles();
        $return = $daoOperador->addFile($data);

        if($return){
            return true;
        }else{
            return false;
        }
    }
}

?>