<?php
namespace DAO;

require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/operador.php');
use models\Operador;

/**
 * 
 * classe responsável por fazer a comunicação entre o DB
 * provendo funções básicas de CRUD
 * @author Arthur Alves
 * @package DAO
 */
class DAOoperador{
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
     * faz a inclusão do operador, recebe um objeto do tipo operador e faz a inclusão no banco;
     * @param objeto operador
     * @return true|Exception
     */
    public function addOperador($operador){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        try{
        $sqlInsert = $conexaoDB->prepare("INSERT INTO operators(`name`, email, password_hash) values (?,?,?)");
        $sqlInsert->bind_param("sss", $operador->nomeOperador, $operador->email, $operador->senha);
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

    /**
     * Faz a busca do Operador dado Email 
     * e para o valida login
     * @return Array|Exception
     */
    public function getOperador($email){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }

        try{
            $sqlSelect = $conexaoDB->prepare("SELECT * FROM operators where email = ?");
            $sqlSelect->bind_param("s", $email);
            $sqlSelect->execute();

            $resultado = $sqlSelect->get_result();

            if($resultado->num_rows > 0){
                $operador = $resultado->fetch_assoc();
                $sqlSelect->close();
                $conexaoDB->close();
                return $operador;
            }else{
                $sqlSelect->close();
                $conexaoDB->close();
                return json_encode(['message'=>'nenhum operador encontrado']);
            }
        }catch(\Exception $e){
            $sqlSelect->close();
            $conexaoDB->close();
            return ['error' => 'Erro na consulta: ' . $e->getMessage()];
        }

    }
}

?>