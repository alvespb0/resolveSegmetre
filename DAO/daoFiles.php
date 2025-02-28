<?php
namespace DAO;

require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/files.php');
use models\Files;

/**
 * 
 * classe responsável por fazer a comunicação entre o DB
 * provendo funções básicas de CRUD
 * @author Arthur Alves
 * @package DAO
 */
class DAOfiles{
    /**
     * Estabelece a conexão com o banco de dados.
     *
     * @return \MySQLi
     * @throws \Exception
     */
    private function conectarBanco() {
        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }
        if (!defined('BASE_DIR')) {
            define('BASE_DIR', dirname(__FILE__) . DS);
        }

        require(BASE_DIR . '../api/config/database.php'); // Inclui as configurações do banco de dados

        try {
            $conn = new \MySQLi($dbhost, $user, $password, $banco);  // Cria a conexão
            return $conn;
        } catch (mysqli_sql_exception $e) {
            throw new \Exception("Erro na conexão com o banco de dados: " . $e->getMessage());  // Lança exceção se a conexão falhar
        }
    }

    /**
     * faz a inclusão do file, recebe um objeto do tipo file e faz a inclusão
     * @param objeto files
     * @return true|Exception
     */
    public function addFile($file){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }
        
        try{
            $sqlInsert = $conexaoDB->prepare("INSERT INTO files(company_id, file_name, file_path, uploaded_at, user_id)
                                             values (?,?,?,?,?)");
            $sqlInsert->bind_param("isssi", $file->companyId, $file->nameFile, $file->filePath, $file->dataUpload, $file->userId);
            $sqlInsert->execute();

            if(!$sqlInsert->error){
                $sqlInsert->close();
                $conexaoDB->close();
                return true;
            }else{
                $sqlInsert->close();
                $conexaoDB->close();
                throw new \Exception ("não foi possível incluir o operador");
                die;
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }

}
?>