<?php
namespace controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/DAO/daoOperador.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Model/operador.php');

use DAO\DAOoperador;
use models\Operador;

/**
 * classe responsável por fazer os tratamento de dados vindas da API (via JSON) ou envio de requests para a DAO
 * @author Arthur Alves
 */
class ControllerOperador{
    /**
     * recebe uma array vinda da API, após receber a ARRAY cria um objeto do tipo operador
     * e chama a função da DAO passando como parâmetro o objeto operador;
     * @param Array data
     * @return bool
     */
    public function createOperador($data){
        $operador = new Operador;
        $operador->nomeOperador = $data['usuario'];
        $operador->email = $data['email'];
        $operador->setor = $data['type'];
        $operador->senha = password_hash($data['senha'], PASSWORD_DEFAULT);
        $daoOperador = new DAOoperador();
        $return = $daoOperador->addOperador($operador);

        if($return){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Recebe um email e chama a função getOperador
     * @param string
     * @return Array|false
     */
    public function obtainOperador($email){
        $daoOperador = new DAOoperador;
        $operador = $daoOperador->getOperador($email);

        if($operador){
            return $operador;
        }else{
            return false;
        }
    }

    /**
     * recebe uma array de todos os operadores, não é necessário ajustar dados
     * @return Array|false
     */
    public function obtainAllOperadores(){
        $daoOperador = new DAOoperador;
        $operadores = $daoOperador->getAllOperadores();

        if($operadores){
            return $operadores;
        }else{
            return false;
        }
    }

    /**
     * recebe um id e deleta o operador vinculado a esse id
     * @param int
     * @return bool
     */
    public function deleteOperador($id){
        $daoOperador = new DAOoperador;
        $daoOperador->deleteOperadorById($id);
    }

    
    /**
     * recebe um id company e chama a função getUserByIdCompany e retorna um array encaminhando o name
     * @param int 
     * @return Array|false
     */
    public function getOperatorNameById($id){
        $daoOperador = new DAOoperador;
        $operador = $daoOperador->getOperatorById($id);
        if(!empty($operador['name'])){
            return $operador['name'];
        }else{
            return false;
        }
    }
}
?>