<?php
namespace models;

/**
 * classe model para a tabela usuario
 * representa os dados da tabela user
 */

class Usuario{
    /**
     * ID do usuario (no banco é id)
     * @var int
     */
    public $idUsuario;

    /**
     * ID da empresa, FK para representar a empresa (no banco é company_id)
     * @var int
     */
    public $idEmpresa;

    /**
     * nome do usuário (no banco é name)
     * @var string
     */
    public $nomeFuncionario;

    /**
     * email do usuário (no banco é email)
     * @var string
     */
    public $emailUsuario;

    /**
     * senha do usuário (no banco é password_hash)
     * @var string
     */
    public $senhaUsuario;

    public function __construct($idUsuario = null, $idEmpresa = null, $nomeFuncionario = null,
                                $emailUsuario = null, $senhaUsuario = null){
            $this->idUsuario = $idUsuario;
            $this->idEmpresa = $idEmpresa;
            $this->nomeFuncionario = $nomeFuncionario;
            $this->emailUsuario = $emailUsuario;
            $this->senhaUsuario = $senhaUsuario;                
    }
}

?>