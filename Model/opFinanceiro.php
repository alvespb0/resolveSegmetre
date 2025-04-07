<?php
namespace models;

/**
 * classe model para a tabela operador
 * representa os dados da tabela operator
 */

class OpFinanceiro{
    /**
     * ID do operador Financeiro (no banco é id)
     * @var int
     */
    public $idFinanceiro;

    /**
     * Nome do operador Financeiro (no banco é name)
     * @var string
     */
    public $nomeFinanceiro;

    /**
     * email do operador Financeiro (no banco é email, e é unico)
     * @var string
     */
    public $email;

    /**
     * Senha do operador Financeiro (no banco é password_hash);
     * @var string
     */
    public $senha;

    public function __construct($idFinanceiro = null, $nomeFinanceiro = null, $email = null, $senha = null){
        $this->idFinanceiro = $idFinanceiro;  
        $this->nomeFinanceiro = $nomeFinanceiro;
        $this->email = $email;
        $this->senha = $senha;
    }
}
?>