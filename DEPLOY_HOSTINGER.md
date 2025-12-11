# Guia de Deploy - Losfit.com.br (Hostinger)

## Visão Geral
Este projeto utiliza um script automatizado (`deploy_hostinger.ps1`) para preparar, empacotar e enviar a aplicação para o servidor Hostinger.

> [!CAUTION]
> **SEGURANÇA**: O script `deploy_hostinger.ps1` contém a senha do servidor. **NUNCA commite este arquivo no Git.** Ele já está incluído no `.gitignore`.

## Pré-requisitos
- Acesso SSH ao servidor (configurado no script)
- Banco de dados importado no Hostinger (já realizado)

## Como Fazer Deploy

1. **Abra o PowerShell** na raiz do projeto:
   ```powershell
   cd c:\xampp\htdocs\ecommerce\ecommerce-hp
   ```

2. **Execute o script de deploy**:
   ```powershell
   .\deploy_hostinger.ps1
   ```

### O que o script faz:
1. **Prepara Arquivos**: Cria uma cópia limpa do projeto sem arquivos de desenvolvimento (.git, node_modules, tests, etc).
2. **Configura Produção**: Prepara o `.env` e o `.htaccess` com suporte a PHP 8.4.
3. **Upload**: Compacta tudo em um ZIP e envia via SCP.
4. **Instalação Remota**:
   - Descompacta no servidor
   - Instala dependências PHP (Composer)
   - Ajusta permissões de pastas
   - Limpa e reconstrói caches do Laravel

## Pós-Deploy

Após o script finalizar, verifique:
1. Acesse **https://losfit.com.br**
2. Se houver erro 500, verifique os logs no servidor: `storage/logs/`
3. Se precisar alterar configurações, edite o `.env` no servidor via SSH ou Gerenciador de Arquivos do Hostinger.

## Comandos Úteis (SSH)

Conectar ao servidor:
```bash
ssh -p 65002 u488238372@185.245.180.69
```

 limpar caches manualmente:
```bash
cd public_html
php artisan optimize:clear
```
