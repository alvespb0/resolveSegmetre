<?php
namespace models;

/**
 * classe responsável pela representação da tabela files
 * representa os atributos da tabela
 */
class Files{
    /**
     * ID do file (no banco é id)
     * @var int
     */
    public $idFile;

    /**
     * nome do file (no banco é file_name)
     * @var string
     */
    public $nameFile;

    /**
     * caminho para o file (no banco é file_path)
     * @var string
     */
    public $filePath;

    /**
     * data de upload (no banco é uploaded_at e é timestamp)
     * @var string
     */
    public $dataUpload;

    /**
     * chave estrangeira referente a user ID (no banco é user_id)
     * @var int
     */
    public $userId;

    /**
     * chave estrangeira referente ao ID da empresa (no banco é company_id)
     * @var int
     */
    public $companyId;

    public function __construct($idFile = null, $nameFile = null, $filePath = null, $dataUpload = null, $userId = null, $companyId = null){
        $this->idFile = $idFile;
        $this->nameFile = $nameFile;
        $this->filePath = $filePath;
        $this->dataUpload = $dataUpload;
        $this->userId = $userId;
        $this->companyId = $companyId;
    }
}

?>