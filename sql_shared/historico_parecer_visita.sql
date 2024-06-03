CREATE TABLE historico_parecer_visita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_visitas INT NOT NULL,
    numero_parecer VARCHAR(5) NOT NULL,
    ano_parecer VARCHAR(4) NOT NULL,
    codigo_familiar VARCHAR(50) NOT NULL,
    data_entrevista VARCHAR(10) NOT NULL,
    renda_per_capita VARCHAR(12) NOT NULL,
    localidade VARCHAR(100) NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    nome_logradouro VARCHAR(255) NOT NULL,
    numero_logradouro VARCHAR(20) NOT NULL,
    complemento_numero VARCHAR(10) NOT NULL,
    complemento_adicional VARCHAR(15) NOT NULL,
    cep VARCHAR(25) NOT NULL,
    referencia_localizacao TEXT NOT NULL,
    situacao VARCHAR(50) NOT NULL,
    resumo_visita TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE membros_familia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parecer_id INT NOT NULL,
    parentesco VARCHAR(50) NOT NULL,
    nome_completo VARCHAR(100) NOT NULL,
    nis VARCHAR(50) NOT NULL,
    data_nascimento VARCHAR(40) NOT NULL,
    FOREIGN KEY (parecer_id) REFERENCES historico_parecer_visita(id) ON DELETE CASCADE
);
