<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

class ConsultaModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function consultarFamilia($consulta)
    {
        $stmt = $this->conn->prepare("SELECT * FROM status_familia WHERE cod_familiar LIKE ? ");
        $param = "%$consulta%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
        
    }

    public function listarCadastros_fichario()
    {
        $result = $this->conn->query("SELECT * FROM cadastro_forms");
        return $result;
    }

    public function consultarPorCodFamiliar($codFamiliar)
    {
        $stmt = $this->conn->prepare("SELECT * FROM cadastro_forms WHERE cod_familiar_fam = ?");
        $stmt->bind_param("s", $codFamiliar);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>
