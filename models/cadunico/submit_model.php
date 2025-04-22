<?php
class CadastroModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function adicionarCadastro($ajustando_cod, $data_entrevista, $tipo_documento, 
    $arquivo_binario, $arquivo_tamanho, $nome_arquivo, $arquivo_mime, $resumo, $sit_beneficio, $operador) {
        $stmt = $this->conn->prepare("INSERT INTO cadastro_forms (cod_familiar_fam, data_entrevista, 
        tipo_documento, arquivo, tamanho, nome_arquivo, tipo_mime, obs_familia, sit_beneficio, operador) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssbisss", $ajustando_cod, $data_entrevista, $tipo_documento, 
        $arquivo_binario, $arquivo_tamanho, $nome_arquivo, $arquivo_mime, $resumo, $sit_beneficio, $operador);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }
    

    public function adicionarSitBenefi($ajustando_cod, $resumo, $sit_beneficio, $operador) {
        $stmt = $this->conn->prepare("INSERT INTO sit_beneficio (cod_familiar_fam, obs_familia, sit_beneficio, operador) 
        VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $ajustando_cod, $resumo, $sit_beneficio, $operador);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
      $stmt->close();
    }
}
?>