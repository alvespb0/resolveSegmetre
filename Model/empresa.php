<?php
namespace models;

/**
 * classe model para a tabela empresa
 * representa os dados da tabela companies
 */
class Empresa{
    /**
     * ID da empresa (no banco é id)
     * @var int
     */
    public $idEmpresa;

    /**
     * CNPJ da empresa (no banco é CNPJ e é UNICO)
     * @var string
     */
    public $CNPJEmpresa;

    public function __construct($idEmpresa = null, $CNPJEmpresa = null){
        $this->idEmpresa = $idEmpresa;
        $this->CNPJEmpresa = $CNPJEmpresa;
    }

}
?>