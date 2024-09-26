-- Criar banco de dados e tabela de produtos (se ainda não existir)
CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    preco DECIMAL(10, 2),
    imagem VARCHAR(100)
);

INSERT INTO produtos (nome, preco, imagem) VALUES
('Produto 1', 100.00, 'Produto1.png'),
('Produto 2', 150.00, 'Produto2.png'),
('Produto 3', 200.00, 'Produto3.png');

-- Criar tabela de usuários para login
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);
