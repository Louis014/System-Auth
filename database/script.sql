CREATE DATABASE IF NOT EXISTS `System_auth`;

USE `System_auth`;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `senha_hash` VARCHAR(255) NOT NULL,
    `telefone` VARCHAR(15) NOT NULL,
    `cpf` VARCHAR(14) NOT NULL UNIQUE,
    `data_cadastro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `ativo` BOOLEAN NOT NULL DEFAULT 1,
    `plano` varchar(100) Not Null default "Gratuito"
);

CREATE TABLE IF NOT EXISTS cadastros_pendentes (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    token CHAR(4) NOT NULL,
    expira_em DATETIME NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_email (email),
    UNIQUE KEY unique_cpf (cpf),
    INDEX idx_token_expira (expira_em)
);