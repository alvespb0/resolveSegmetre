<?php
namespace DAO;

require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/empresa.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/usuario.php');

use models\Empresa;
use models\Usuario;

/**
 * classe responsável por fazer a comunicação entre o DB
 * provendo funções básicas de CRUD
 * @author Arthur Alves
 * @package DAO
 */
class DAOusuario{
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

        require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/api/config/database.php'); // Inclui as configurações do banco de dados

        try {
            $conn = new \MySQLi($dbhost, $user, $password, $banco);  // Cria a conexão
            return $conn;
        } catch (mysqli_sql_exception $e) {
            throw new \Exception("Erro na conexão com o banco de dados: " . $e->getMessage());  // Lança exceção se a conexão falhar
        }
    }

    /**
     * faz a inclusão do usuario, recebe um objeto do tipo empresa e do tipo usuario e faz a inclusão;
     * @param objeto usuario
     * @param objeto empresa
     * @return true|Exception
     */
    public function addUsuario($usuario, $empresa){
        try{
            $conexaoDB = $this->conectarBanco();
        }catch(\Exception $e){
            die($e->getMessage());
        }
        
        try{
            $sqlBusca = $conexaoDB->prepare("SELECT * FROM companies WHERE CNPJ = ?");
            $sqlBusca->bind_param("s", $empresa->CNPJEmpresa);
            $sqlBusca->execute();

            $resultado = $sqlBusca->get_result();
            if($resultado->num_rows > 0){
                /* se o resultado for maior que 0 então a empresa já existe então apenas será cadastrado o usuário com base no ID desse CNPJ encontrado */
                while($linha = $resultado->fetch_assoc()){
                    $idEmpresa = $linha['id'];
                }
                $sqlInsert = $conexaoDB->prepare("INSERT INTO users(company_id, email, `name`, password_hash) values (?,?,?,?)");
                $sqlInsert->bind_param("isss", $idEmpresa, $usuario->emailUsuario, $usuario->nomeFuncionario, $usuario->senhaUsuario);
                $sqlInsert->execute();
                
                if(!$sqlInsert->error){
                    $sqlInsert->close();
                    $conexaoDB->close();
                    return true;
                }else{
                    $sqlInsert->close();
                    $conexaoDB->close();
                    throw new \Exception ("não foi possível incluir o Usuario");
                    die;
                }
            }else{
                $sqlInsertEmpresa = $conexaoDB->prepare("INSERT INTO companies (CNPJ) values (?)");
                $sqlInsertEmpresa->bind_param("s", $empresa->CNPJEmpresa);
                $sqlInsertEmpresa->execute();
                $idEmpresa = $conexaoDB->insert_id;

                if(!$sqlInsertEmpresa->error){
                    $sqlInsertUsuario = $conexaoDB->prepare("INSERT INTO users(company_id, email, `name`, password_hash) values (?,?,?,?)");
                    $sqlInsertUsuario->bind_param("isss", $idEmpresa, $usuario->emailUsuario, $usuario->nomeFuncionario, $usuario->senhaUsuario);
                    $sqlInsertUsuario->execute();

                    if(!$sqlInsertUsuario->error){
                        $sqlInsertEmpresa->close();
                        $sqlInsertUsuario->close();
                        $conexaoDB->close();
                        return true;
                    }else{
                        $sqlInsertEmpresa->close();
                        $sqlInsertUsuario->close();
                        $conexaoDB->close();
                        throw new \Exception ("não foi possível incluir o Usuario");
                    }
                }else{
                    $sqlInsertEmpresa->close();
                    $conexaoDB->close();
                    throw new \Exception ("não foi possível incluir a empresa");
                }
            }
        }catch(\Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
    }

}
?>
