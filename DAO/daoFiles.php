<?php
namespace DAO;

require_once($_SERVER['DOCUMENT_ROOT'] . '/Model/files.php');
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
            $sqlInsert = $conexaoDB->prepare("INSERT INTO files(company_id, file_name, file_path, uploaded_at, operator_id)
                                             values (?,?,?,?,?)");
            $sqlInsert->bind_param("isssi", $file->companyId, $file->nameFile, $file->filePath, $file->dataUpload, $file->operatorId);
            $sqlInsert->execute();

            if(!$sqlInsert->error){
                $sqlInsert->close();
                $conexaoDB->close();
                return true;
            }else{
                $sqlInsert->close();
                $conexaoDB->close();
                throw new \Exception ("não foi possível incluir o file");
                die;
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }

    /**
     * recebe o id da empresa e retorna todos os files vinculados nesse 
     * @param int
     * @return Array|Exception
     */
    public function getFilesById($id){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        try{
            $sqlSelect = $conexaoDB->prepare("SELECT * FROM files where company_id = ? ORDER BY id DESC");
            $sqlSelect->bind_param("i", $id);
            $sqlSelect->execute();
            $resultado = $sqlSelect->get_result();

            $files = [];

            if($resultado->num_rows > 0){
                while ($row = $resultado->fetch_assoc()) {
                    $files[] = $row; // Adiciona cada linha no array
                }
                $sqlSelect->close();
                $conexaoDB->close();
                return $files;
            }else{
                return json_encode(["Error" => "Nenhum arquivo localizado"]);
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }

    /**
     * recebe o id (primary key) do arquivo e retorna o path, será utilizado para apagar o arquivo da pasta mesmo
     * @var int
     * @return Array|Exception
     */
    public function getFileByIndex($id){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }
        try{
            $sqlSelect = $conexaoDB->prepare("SELECT file_path FROM files where id = ?");
            $sqlSelect->bind_param("i", $id);
            $sqlSelect->execute();

            $resultado = $sqlSelect->get_result();

            if($resultado->num_rows !== 0){
                return $resultado->fetch_assoc();
            }else{
                return json_encode(["Error" => "Erro ao deletar a pasta do arquivo"]);
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }

    /**
     * recebe todos os files dado o select
     * @return Array|Exception
     */
    public function getAllFiles(){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }
        try{
            $sqlSelect = "SELECT file_name, id, uploaded_at, operator_id, company_id, file_path FROM files ORDER BY file_name ASC";
            $resultado = $conexaoDB->query($sqlSelect);

            if ($resultado === false) {
                throw new \Exception("Erro ao executar a consulta: " . $conexaoDB->error); 
            }else{
                $files = [];
                while($row = $resultado->fetch_assoc()){
                    $files [] = $row;
                }
                $conexaoDB->close();
                return $files;
            }
        }catch(\Exception $e){
            die($e->getMessage());
        }
    }
    
    /**
     * recebe uma data e retorna todos os registros dado essa data
     * @param string
     * @return Array|Exception
     */
    public function getFilesByDate($date){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        try{
            $sqlSelect = $conexaoDB->prepare("SELECT * FROM files where uploaded_at like ?");
            $sqlSelect->bind_param("s", $date);
            $sqlSelect->execute();

            $resultado = $sqlSelect->get_result();

            if ($resultado === false) {
                throw new \Exception("Erro ao executar a consulta: " . $conexaoDB->error); 
            }else{
                $files = [];
                while($row = $resultado->fetch_assoc()){
                    $files [] = $row;
                }
                $conexaoDB->close();
                return $files;
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }

    /**
     * recebe uma data e retorna todos os registros dado essa data FILTRADO PELO COMPANY ID
     * @param string
     * @return Array|Exception
     */
    public function getFilesByDateFilteredCompany($date, $id){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        try{
            $sqlSelect = $conexaoDB->prepare("SELECT * FROM files where uploaded_at like ? and company_id = ?");
            $sqlSelect->bind_param("si", $date, $id);
            $sqlSelect->execute();

            $resultado = $sqlSelect->get_result();

            if ($resultado === false) {
                throw new \Exception("Erro ao executar a consulta: " . $conexaoDB->error); 
            }else{
                $files = [];
                while($row = $resultado->fetch_assoc()){
                    $files [] = $row;
                }
                $conexaoDB->close();
                return $files;
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }
    

    /**
     * recebe um search e retorna os exames dado esse parâmetro, será usado o LIKE para isso
     * @param string
     * @return Array|Exception
     */
    public function getFilesBySearch($search){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        try{
            $search = "%" . $search . "%";
            $sqlSelect = $conexaoDB->prepare("SELECT * FROM files where file_name like ?");
            $sqlSelect->bind_param("s", $search);
            $sqlSelect->execute();

            $resultado = $sqlSelect->get_result();

            if ($resultado === false) {
                throw new \Exception("Erro ao executar a consulta: " . $conexaoDB->error); 
            }else{
                $files = [];
                while($row = $resultado->fetch_assoc()){
                    $files [] = $row;
                }
                $conexaoDB->close();
                return $files;
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }

    /**
     * recebe um search e retorna os exames dado esse parâmetro, será usado o LIKE para isso FILTRADO PELO COMPANY ID
     * @param string
     * @param int
     * @return Array|Exception
     */
    public function getFilesBySearchFilteredCompany($search, $id){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        try{
            $search = "%" . $search . "%";
            $sqlSelect = $conexaoDB->prepare("SELECT * FROM files where file_name like ? and company_id = ?");
            $sqlSelect->bind_param("si", $search, $id);
            $sqlSelect->execute();

            $resultado = $sqlSelect->get_result();

            if ($resultado === false) {
                throw new \Exception("Erro ao executar a consulta: " . $conexaoDB->error); 
            }else{
                $files = [];
                while($row = $resultado->fetch_assoc()){
                    $files [] = $row;
                }
                $conexaoDB->close();
                return $files;
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }
    /**
     * recebe um id de company e faz a exclusão de TODOS os arquivos dado a ID company
     * @param int
     * @return TRUE|Exception
     */
    public function deleteFilesByIdCompany($id){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        $sqlDelete = $conexaoDB->prepare("DELETE from files where company_id = ?");
        $sqlDelete->bind_param("i", $id);
        $sqlDelete->execute();

        if(!$sqlDelete->error){
            $retorno = TRUE;
        }else{
            throw new \Exception("Não foi possível excluir os arquivos");
            die;
        }
        $conexaoDB->close();
        $sqlDelete->close();
        return $retorno;
    }

    /**
     * recebe um id de company e faz a exclusão de TODOS os arquivos dado a ID company
     * @param int
     * @return TRUE|Exception
     */
    public function deleteFilesById($id){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        $sqlDelete = $conexaoDB->prepare("DELETE from files where id = ?");
        $sqlDelete->bind_param("i", $id);
        $sqlDelete->execute();

        if(!$sqlDelete->error){
            $retorno = TRUE;
        }else{
            throw new \Exception("Não foi possível excluir os arquivos");
            die;
        }
        $conexaoDB->close();
        $sqlDelete->close();
        return $retorno;
    }
}
?>