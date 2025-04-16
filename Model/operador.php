<?php
namespace models;

/**
 * classe model para a tabela operador
 * representa os dados da tabela operator
 */

class Operador{
    /**
     * ID do operador (no banco é id)
     * @var int
     */
    public $idOperador;

    /**
     * Nome do operador (no banco é name)
     * @var string
     */
    public $nomeOperador;

    /**
     * email do operador (no banco é email, e é unico)
     * @var string
     */
    public $email;

    /**
     * Senha do operador (no banco é password_hash);
     * @var string
     */
    public $senha;

    /**
     * Setor do operador (no banco é setor)
     * @var string
     */
    public $setor;

    public function __construct($idOperador = null, $nomeOperador = null, $email = null, $senha = null, $setor = null){
        $this->idOperador = $idOperador;  
        $this->nomeOperador = $nomeOperador;
        $this->email = $email;
        $this->senha = $senha;
        $this->setor = $setor;
    }
}
?>