<?php
class CadastroModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function adicionarCadastro(
        $codigo_familiar_fam, 
        $data_entrevista, 
        $tipo_documento, 
        $arquivo_binario, 
        $arquivo_tamanho, 
        $nome_arquivo, 
        $arquivo_mime, 
        $resumo, 
        $sit_beneficio, 
        $operador
    ) {
        // Inicializamos $null explicitamente
        $null = null;
    
        $stmt = $this->conn->prepare("
            INSERT INTO cadastro_forms (
                cod_familiar_fam, 
                data_entrevista, 
                tipo_documento, 
                arquivo, 
                tamanho, 
                nome_arquivo, 
                tipo_mime, 
                obs_familia, 
                sit_beneficio, 
                operador
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        // Usamos $null como placeholder para o dado binário
        $stmt->bind_param(
            "sssbsissss", 
            $codigo_familiar_fam, 
            $data_entrevista, 
            $tipo_documento, 
            $null, // Placeholder
            $arquivo_tamanho, 
            $nome_arquivo, 
            $arquivo_mime, 
            $resumo, 
            $sit_beneficio, 
            $operador
        );
        
        // Aqui enviamos o conteúdo binário para o MySQL
        $stmt->send_long_data(3, $arquivo_binario);
    
        $resultado = $stmt->execute();
        if (!$resultado) {
            error_log("Erro no MySQL: " . $stmt->error); // Log para depuração
        }
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