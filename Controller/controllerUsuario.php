<?php
namespace controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/DAO/DAOUsuario.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/empresa.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ResolveSegmetre/Model/usuario.php');

use models\Empresa;
use models\Usuario;
use DAO\DAOusuario;

/**
 * classe responsável por fazer os tratamento de dados vindas da API (via JSON) ou envio de requests para a DAO
 * @author Arthur Alves
 */
class ControllerUsuario{
    /**
     * recebe uma array vinda da API, após receber a ARRAY cria um objeto do tipo usuario e outro do tipo empresa
     * e chama a função da DAO passando como parâmetro ambos os objetos como parâmetro;
     * @param Array data
     * @return bool
     */
    public function createUsuario($data){
        $usuario = new Usuario;
        $usuario->nomeFuncionario = $data['usuario'];
        $usuario->emailUsuario = $data['email'];
        $usuario->senhaUsuario = password_hash($data['senha'], PASSWORD_DEFAULT);
        
        $empresa = new Empresa;
        $empresa->CNPJEmpresa = $data['cnpj'];

        $daoUsuario = new DAOusuario;
        $return = $daoUsuario->addUsuario($usuario, $empresa);

        if($return){
            return true;
        }else{
            return false;
        }
    }
}
?>