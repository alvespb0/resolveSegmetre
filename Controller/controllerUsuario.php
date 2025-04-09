<?php
namespace controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/DAO/daoUsuario.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Model/empresa.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Model/usuario.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/phpMailer/phpMailer.php');

use models\Empresa;
use models\Usuario;
use DAO\DAOusuario;
use mail\Mailer;

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

    /**
     * recebe um id company chama a função getUserByIdCompany($id) e chama a função do php mailer
     * @param int
     * @return bool
     */
    public function sendEmail($id){
        $daoUsuario = new DAOusuario;
        $email = $daoUsuario->getUserByIdCompany($id);
        
        if(!empty($email['email'])){
            $mailer = new Mailer();
            if($mailer->enviarEmail($email['email'])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * recebe um id company e chama a função getUserByIdCompany e retorna um array encaminhando o name
     * @param int 
     * @return Array|false
     */
    public function getUserNameByIdCompany($id){
        $daoUsuario = new DAOusuario;
        $usuario = $daoUsuario->getUserByIdCompany($id);
        if(!empty($usuario['name'])){
            return $usuario['name'];
        }else{
            return false;
        }
    }

    /**
     * Recebe um email e chama a função getUsuario
     * @param string
     * @return Array|false
     */
    public function obtainUsuario($email){
        $daoUsuario = new DAOusuario;
        $usuario = $daoUsuario->getUsuario($email);

        if($usuario){
            return $usuario;
        }else{
            return false;
        }
    }

    /**
     * Recebe todos os logins de usuarios e sua company_id em forma de array associativa
     * @return Array|Exception
     */
    public function obtainUserNameASC2(){
        $daoUsuario = new DAOusuario;
        try{
        $empresas = $daoUsuario->getUserNameASC2();
        return $empresas;
        }catch(\Exception $e){
            return ['error' => 'Erro: ' . $e->getMessage()];
        }
    }

    /**
     * recebe um id e deleta o operador vinculado a esse id
     * @param int
     * @return bool
     */
    public function deleteUsuario($id){
        $daoUsuario = new DAOusuario;
        $daoUsuario->deleteUsuarioById($id);
        unset($daoUsuario);
    }

    /**
     * recebe um id e deleta o operador vinculado a esse id
     * @param int
     * @return bool
     */
    public function deleteCompany($id){
        $daoUsuario = new DAOusuario;
        $daoUsuario->deleteCompanyById($id);
    }

    /**
     * lança uma request para a função genTokenCadastro contendo token e expiração gerado na controller.
     * Feito isso, ele retorna o link
     * @return string|Exception
     */
    public function getLinkCadastro(){
        $daoUsuario = new DAOusuario;
        try{
            $token = bin2hex(random_bytes(32));
            $expiracao = date('Y-m-d H:i:s', strtotime('+24 hours'));
            $retorno = $daoUsuario->genTokenCadastro($token, $expiracao);

            if($retorno == true){
                $link = "https://resolvesegmetre.com.br:1443/view/cadastroCliente.php?token=$token";
                return $link;
            }else{
                throw new \Exception("Erro ao gerar token de cadastro.");
            }
        }catch(\Exception $e){
            return ['error' => 'Erro: ' . $e->getMessage()];
        }
    }

    /**
     * envia um token para a DAO validar se o retorno da DAO for true, então return true, se não return false.
     * @param string
     * @return bool
     */
    public function validaToken($token){
        $daoUsuario = new DAOusuario;
        return $daoUsuario->validateTokenCadastro($token);
    }

    /**
     * Envia um token já utilizada para a DAO, a DAO atualiza a tabela setando usado = 1
     * @param string 
     * @return bool
     */
    public function invalidaToken($token){
        $daoUsuario = new DAOusuario;
        return $daoUsuario->inativaTokenCadastro($token);
    }
    
    /**
     * lança uma request para a função genTokenSenha contendo token e expiração gerado na controller.
     * Feito isso, ele retorna o link
     * @return string|Exception
     */
    public function getLinkRecSenha($email){
        $daoUsuario = new DAOusuario;
        try{
            $usuario = $this->obtainUsuario($email); #valida se o usuario existe dado o email

            if(is_array($usuario)){  # se usuario existir vai retornar uma array com as informações do usuario

                $idUsuario = $usuario['id'];
                $token = bin2hex(random_bytes(32));
                $expiracao = date('Y-m-d H:i:s', strtotime('+1 hours'));
                $retorno = $daoUsuario->genTokenSenha($token, $expiracao, $idUsuario);
                
                if($retorno == true){
                    $link = "https://resolvesegmetre.com.br:1443/view/esqueciMinhaSenha.php?token=$token";
                    return $link;
                }else{
                    throw new \Exception("Erro ao gerar token de cadastro.");
                }
            }else{
                return false; #não encontrado nenhum cliente com esse email;
            }
        }catch(\Exception $e){
            return ['error' => 'Erro: ' . $e->getMessage()];
        }
    }

    /**
     * pega o link do getLinkRecSenha e manda um email com PHP mailer;
     * @param string $email
     * @param string $link
     * @return bool
     */
    public function enviaEmailSenha($email, $link){
        $mailer = new Mailer();
        return $mailer->enviaEmailRecuperacao($email, $link);
    }

}
?>