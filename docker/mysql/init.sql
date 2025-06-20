CREATE DATABASE IF NOT EXISTS mini_erp;

USE mini_erp;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE variacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    estoque INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

CREATE TABLE estoque (
  id INT AUTO_INCREMENT PRIMARY KEY,
  produto_id INT,
  variacao VARCHAR(100),
  quantidade INT,
  FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

CREATE TABLE pedido_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

INSERT INTO pedido_status (nome) VALUES
('Pendente'),
('Aguardando Entrega'),
('Em Transporte'),
('Entregue'),
('Cancelado');

CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  status_id INT NOT NULL DEFAULT 1,
  subtotal DECIMAL(10,2),
  frete DECIMAL(10,2),
  total DECIMAL(10,2),
  desconto DECIMAL(10,2),
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (status_id) REFERENCES pedido_status(id)
);

CREATE TABLE pedido_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    variacao_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (variacao_id) REFERENCES variacoes(id)
);

CREATE TABLE cupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    tipo ENUM('percentual', 'valor') NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    validade DATE NOT NULL,
    valor_minimo DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE enderecos_entrega (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    cep VARCHAR(9) NOT NULL,
    logradouro VARCHAR(255) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    complemento VARCHAR(100),
    bairro VARCHAR(100) NOT NULL,
    localidade VARCHAR(100) NOT NULL,
    uf CHAR(2) NOT NULL,
    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE
);

CREATE TABLE usuario_perfis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    usuario_perfil_id INT,
    FOREIGN KEY (usuario_perfil_id) REFERENCES usuario_perfis(id)
);





