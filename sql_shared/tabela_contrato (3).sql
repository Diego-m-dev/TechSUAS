CREATE TABLE contrato_empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    cnpj VARCHAR (18),
    nome VARCHAR(100),
    razao VARCHAR(100),
    endereco VARCHAR(255),
    contato VARCHAR(16),
    email VARCHAR(30),
    representante VARCHAR(255),
    contato_representante VARCHAR(14),
    segmento VARCHAR(30),
    operador VARCHAR(255),
    data_cadastro VARCHAR(16)
) ENGINE=InnoDB;

CREATE TABLE contrato_tbl (
    id_contrato INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT,
	num_contrato VARCHAR(14),
	data_assinatura DATE,
    vigencia VARCHAR(10),
    fiscal VARCHAR(100),
    valor VARCHAR(15),
    tipo_material VARCHAR(100),
    operador VARCHAR(255),
    data_cadastro VARCHAR(16),
    FOREIGN KEY (id_empresa) REFERENCES contrato_empresa(id_empresa)
) ENGINE=InnoDB;

CREATE TABLE contrato_historico (
	id_historico INT AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT,
    vigencia VARCHAR(10),
    valor VARCHAR(15),
    termo_adtivo VARCHAR(30),
    operador VARCHAR(255),
    data_cadastro VARCHAR(16),
    FOREIGN KEY (id_contrato) REFERENCES contrato_tbl(id_contrato)
)ENGINE=InnoDB;

CREATE TABLE contrato_itens (
	id_itens INT AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT,
    cod_produto VARCHAR(10),
    nome_produto TEXT(65000),
    marca VARCHAR(50),
    quantidade VARCHAR(10),
    und_medida VARCHAR(15),
    valor_uni VARCHAR(30),
    valor_total VARCHAR(40),
    operador VARCHAR(255),
    data_cadastro VARCHAR(16),
    FOREIGN KEY (id_contrato) REFERENCES contrato_tbl(id_contrato)
)ENGINE=InnoDB;

CREATE TABLE contrato_pedidos (
  id_pedido INT AUTO_INCREMENT PRIMARY KEY,
  id_itens INT,
  cod_produto VARCHAR(10),
  nome_produto TEXT(65000),
  quantidade VARCHAR(10),
  valor_uni VARCHAR(30),
  operador VARCHAR(255),
  data_cadastro VARCHAR(16),
  FOREIGN KEY (id_itens) REFERENCES contrato_itens(id_itens)
)ENGINE=InnoDB;