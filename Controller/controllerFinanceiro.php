<?php
namespace controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/DAO/daoFinanceiro.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Model/opFinanceiro.php');

use DAO\DAOopFinanceiro;
use models\OpFinanceiro;

/**
 * classe responsável por fazer os tratamento de dados vindas da API (via JSON) ou envio de requests para a DAO
 * @author Arthur Alves
 */
class ControllerFinanceiro{
    /**
     * recebe uma array vinda da API, após receber a ARRAY cria um objeto do tipo operador
     * e chama a função da DAO passando como parâmetro o objeto operador;
     * @param Array data
     * @return bool
     */
    public function createOperadorFinanceiro($data){
        $opFinanceiro = new OpFinanceiro;
        $opFinanceiro->nomeFinanceiro = $data['usuario'];
        $opFinanceiro->email = $data['email'];
        $opFinanceiro->senha = password_hash($data['senha'], PASSWORD_DEFAULT);
        $daoOperadorFinanceiro = new DAOopFinanceiro();
        $return = $daoOperadorFinanceiro->addOperador($opFinanceiro);

        if($return === true){
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
    public function obtainOperadorFinanceiro($email){
        $daoOperadorFinanceiro = new DAOopFinanceiro;
        $operadorFinanceiro = $daoOperadorFinanceiro->getOperadorFinanceiro($email);

        if($operadorFinanceiro){
            return $operadorFinanceiro;
        }else{
            return false;
        }
    }
}

?>