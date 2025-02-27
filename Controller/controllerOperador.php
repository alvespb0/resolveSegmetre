<?php
namespace controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/DAO/daoOperador.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/operador.php');

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
        $operador->senha = password_hash($data['senha'], PASSWORD_DEFAULT);
        $daoOperador = new DAOoperador();
        $return = $daoOperador->addOperador($operador);

        if($return){
            return true;
        }else{
            return false;
        }
    }
}
?>