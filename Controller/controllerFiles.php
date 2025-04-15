<?php
namespace controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/DAO/daoFiles.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Model/files.php');

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
    public function createFile($postData, $path){
        $file = new Files;
        $file->nameFile = $postData['file_name'];
        $file->filePath = $path;
        $file->dataUpload = $postData['upload_date'];
        $file->operatorId = $postData['operadorId'];
        $file->companyId = $postData['company_id'];

        $daoFile = new DAOfiles();
        $return = $daoFile->addFile($file);

        if($return){
            return true;
        }else{
            return false;
        }
    }

    /**
     * recebe um ID de empresa e retorna um array 
     * @param int
     * @return Array
     */
    public function obtainFilesbyId($id){
        $daoFile = new DAOfiles();
        $return = $daoFile->getFilesById($id);

        if(is_array($return)){
            unset($daoFile);
            return $return;
        }else{
            return false;
        }
    }

    /**
     * recebe todos os files em um array
     * @return Array|False
     */
    public function obtainAllFiles(){
        $daoFile = new DAOfiles();
        $return = $daoFile->getAllFiles();

        if(is_array($return)){
            unset($daoFile);
            return $return;
        }else{
            return false;
        }
    }
    
    /**
     * chama a função getCountFiles() e retorna o numero de páginas tendo em mente que o limite por pagina é 20
     * @return int
     */
    public function obtainNumberPages(){
        $daoFile = new DAOfiles();
        $return = $daoFile->getCountFiles();
        $totalPaginas = ceil($return/20);
        return $totalPaginas;
    }

    /**
     * recebe um numero de pagina vindo via metodo GET e retorna os files dado esse offset (limit 20)
     * @param int
     * @return Array
     */
    public function obtainFilesByPage($offset){
        $daoFile = new DAOfiles();
        $return = $daoFile->getFilesPaginated($offset);

        if(is_array($return)){
            unset($daoFile);
            return $return;
        }else{
            return false;
        }
    }

    /**
     * recebe um date e retorna os files dado esse date
     * @param string
     * @return Array|False
     */
    public function obtainFilesByDate($date){
        $daoFile = new DAOfiles();
        $return = $daoFile->getFilesByDate($date);
        if(is_array($return)){
            unset($daoFile);
            return $return;
        }else{
            return false;
        }
    }
    
   /**
     * recebe um date e retorna os files dado esse date
     * @param string
     * @return Array|False
     */
    public function obtainFilesByDateFilteredCompany($date, $id){
        $daoFile = new DAOfiles();
        $return = $daoFile->getFilesByDateFilteredCompany($date, $id);
        if(is_array($return)){
            unset($daoFile);
            return $return;
        }else{
            return false;
        }
    }
    /**
     * recebe um search e retorna os files com esse nome 
     * @param string
     * @return Array|False
     */
    public function obtainFilesBySearch($search){
        $daoFile = new DAOfiles();
        $return = $daoFile->getFilesBySearch($search);
        if(is_array($return)){
            unset($daoFile);
            return $return;
        }else{
            return false;
        }
    }
    
    /**
     * recebe um search e retorna os files com esse nome FILTRADO PELO COMPANY ID
     * @param string
     * @return Array|False
     */
    public function obtainFilesBySearchFilteredCompany($search, $id){
        $daoFile = new DAOfiles();
        $return = $daoFile->getFilesBySearchFilteredCompany($search, $id);
        if(is_array($return)){
            unset($daoFile);
            return $return;
        }else{
            return false;
        }
    }

    /**
     * recebe um id e deleta os files vinculado a esse id de empresa
     * @param int
     * @return bool
     */
    public function deleteFiles($id){
        $daoFile = new DAOfiles();
        $daoFile->deleteFilesByIdCompany($id);
        unset($daoFile);
    }

    /**
     * recebe um id e deleta os files vinculado a esse id
     * @param int
     * @return bool|Exception
     */
    public function deleteFilesId($id){
        $daoFile = new DAOfiles();
        $file_path = $daoFile->getFileByIndex($id); #recebe o file_path para excluir na pasta também
        try{
            if(file_exists($file_path['file_path'])){
                if(unlink($file_path['file_path'])){
                    $daoFile->deleteFilesById($id); #deleta o metadado inteiro do file no bd
                    unset($daoFile);
                    return true;
                }else{
                    return json_encode(["Error" => "Erro ao deletar arquivo da pasta"]);
                }
            }else{
                $daoFile->deleteFilesById($id); #deleta apenas o metadado para um arquivo que não existe no repositório
                unset($daoFile);
                return true;
            }
        }catch(\Exception $e){
            return json_encode(["Error" => $e->getMessage()]);
        }   
    }
}

?>