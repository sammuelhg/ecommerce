# 🗄️ CONFIGURAÇÃO DO MYSQL - GUIA ATUALIZADO

Este guia descreve como configurar o banco de dados MySQL para o projeto **Ecommerce HP**, utilizando o XAMPP.

## ⚙️ Configuração Atual do Sistema

O projeto está configurado para rodar com o MySQL na porta **3307** (configuração comum em ambientes XAMPP para evitar conflitos).

### Credenciais do Banco
- **Host:** `127.0.0.1`
- **Porta:** `3307`
- **Database:** `ecommerce_hp`
- **Usuário:** `root`
- **Senha:** *(vazio)*

---

## 📋 PASSOS PARA CONFIGURAÇÃO

### **1️⃣ Criar o Banco de Dados**

1. Abra o phpMyAdmin: **http://localhost/phpmyadmin**
2. Clique em **"Novo"** (menu lateral esquerdo).
3. Nome do banco: `ecommerce_hp`
4. Collation: `utf8mb4_unicode_ci`
5. Clique em **"Criar"**.

---

### **2️⃣ Verificar Arquivo .env**

Certifique-se de que seu arquivo `.env` está configurado exatamente assim:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=ecommerce_hp
DB_USERNAME=root
DB_PASSWORD=
```

> **Nota:** Se o seu MySQL estiver na porta padrão (3306), altere `DB_PORT=3306`.

---

### **3️⃣ Instalar Tabelas e Dados**

Para criar as tabelas e popular com dados iniciais, execute:

```bash
php artisan migrate:fresh --seed
```

Isso irá criar:
- Tabela `users` (com usuário admin padrão)
- Tabela `products` (com produtos de exemplo)
- Tabela `categories`
- Tabelas de `orders` e `order_items`

---

### **4️⃣ Solução de Problemas Comuns**

#### Erro: `SQLSTATE[HY000] [2002] No connection could be made...`
- **Causa:** O MySQL não está rodando ou a porta está errada.
- **Solução:**
    1. Abra o XAMPP Control Panel.
    2. Verifique se o MySQL está verde (Running).
    3. Olhe a coluna "Port" no XAMPP. Se for 3306, mude no `.env` para 3306. Se for 3307, mantenha 3307.

#### Erro: `Unknown database 'ecommerce_hp'`
- **Causa:** O banco de dados não foi criado.
- **Solução:** Volte ao passo 1 e crie o banco no phpMyAdmin.

---

## 🚀 Comandos Úteis

```bash
# Verificar status da conexão
php artisan db:show

# Limpar cache de configuração (sempre use após mudar o .env)
php artisan config:clear
```
