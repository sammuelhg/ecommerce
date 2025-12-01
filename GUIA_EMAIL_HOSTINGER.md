# 📧 CONFIGURAÇÃO DE EMAIL (HOSTINGER)

Para que o sistema envie emails transacionais (recuperação de senha, confirmação de pedido, etc.), utilizaremos o servidor SMTP da Hostinger.

## ⚙️ Credenciais

- **Email:** `contato@losfit.com.br`
- **Senha:** `!Sa002125`
- **Servidor SMTP:** `smtp.hostinger.com`
- **Porta:** `465`
- **Criptografia:** `SSL`

---

## 📝 Como Configurar no Laravel

1. Abra o arquivo `.env` na raiz do projeto (`ecommerce-hp/.env`).
2. Localize as configurações de `MAIL_` e substitua por:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=contato@losfit.com.br
MAIL_PASSWORD="!Sa002125"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="contato@losfit.com.br"
MAIL_FROM_NAME="LosFit Ecommerce"
```

> **Nota:** É importante manter a senha entre aspas se houver caracteres especiais, embora no `.env` geralmente não seja estritamente necessário para `!`, mas é uma boa prática.

---

## 🔄 Aplicar Alterações

Sempre que alterar o arquivo `.env`, limpe o cache de configuração:

```bash
php artisan config:clear
```

## 🚀 Testar Envio

1. Acesse a recuperação de senha: `http://127.0.0.1:8000/password/reset`
2. Tente enviar um link de redefinição para um email seu.
3. Verifique se o email chegou (pode cair no Spam/Lixo Eletrônico inicialmente).
