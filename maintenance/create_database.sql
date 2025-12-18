-- ================================================
-- SCRIPT PARA CRIAR BANCO DE DADOS NO MYSQL
-- ================================================
-- Execute este script no phpMyAdmin (http://localhost/phpmyadmin)
-- OU via linha de comando do MySQL

-- 1. CRIAR O BANCO DE DADOS
CREATE DATABASE IF NOT EXISTS ecommerce_hp 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- 2. USAR O BANCO
USE ecommerce_hp;

-- 3. VERIFICAR CRIAÇÃO
SELECT 'Banco de dados ecommerce_hp criado com sucesso!' AS status;
