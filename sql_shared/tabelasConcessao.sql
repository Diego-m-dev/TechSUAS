CREATE TABLE concessao_tbl (
    id_concessao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    naturalidade VARCHAR(100),
    nome_mae VARCHAR(100),
    contato VARCHAR(16),
    cpf_pessoa VARCHAR(14),
    rg_pessoa VARCHAR(14),
    tit_eleitor_pessoa VARCHAR(14),
    nis_pessoa VARCHAR(12),
    renda_media VARCHAR(100),
    endereco VARCHAR(255),
    operador VARCHAR(255),
    data_cadastro VARCHAR(16)
) ENGINE=InnoDB;

CREATE TABLE concessao_historico (
    id_hist INT AUTO_INCREMENT PRIMARY KEY,
    id_concessao INT,
	num_form VARCHAR(6),
	ano_form VARCHAR(4),
    nome_benef VARCHAR(255),
    nis_benef VARCHAR(12),
    endereco VARCHAR(255),
    renda_media INT,
	parecer TEXT(65000),
    descricao VARCHAR(4),
    nome_item VARCHAR(100),
    qtd_item VARCHAR(10),
    valor_uni VARCHAR(7),
    valor_total VARCHAR(10),
    data_registro VARCHAR(16),
    mes_pag VARCHAR(10),
    operador VARCHAR(255),
    pg_data DATE,
    situacao_concessao VARCHAR(20),
    FOREIGN KEY (id_concessao) REFERENCES concessao_tbl(id_concessao)
) ENGINE=InnoDB;

CREATE TABLE concessao_itens (
	id_itens_conc INT AUTO_INCREMENT PRIMARY KEY,
    cod_item VARCHAR(16),
    caracteristica VARCHAR(100),
    nome_item VARCHAR(100)
);