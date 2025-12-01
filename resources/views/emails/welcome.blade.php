<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #1a1a1a; padding: 20px; text-align: center; }
        .logo { color: #ffd700; font-size: 24px; font-weight: bold; text-decoration: none; }
        .content { padding: 30px 20px; background-color: #f9f9f9; }
        .button { display: inline-block; padding: 10px 20px; background-color: #ffd700; color: #1a1a1a; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('shop.index') }}" class="logo">LosFit</a>
        </div>
        <div class="content">
            <h2>Olá, {{ $user->name }}!</h2>
            <p>Seja muito bem-vindo(a) à LosFit!</p>
            
            <p>Estamos muito felizes em tê-lo(a) conosco. Sua conta foi criada com sucesso através do 
                <strong>{{ $registrationType }}</strong>.
            </p>

            <p>Agora você pode:</p>
            <ul>
                <li>Acompanhar seus pedidos</li>
                <li>Salvar seus produtos favoritos</li>
                <li>Receber ofertas exclusivas</li>
            </ul>

            <center>
                <a href="{{ route('shop.index') }}" class="button">Começar a Comprar</a>
            </center>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} LosFit. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
