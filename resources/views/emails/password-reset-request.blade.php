@extends('emails.layout')

@section('content')
    <p style="font-size: 18px; font-weight: bold; margin-top: 0;">Redefinição de Senha</p>
    
    <p>Recebemos um pedido para redefinir sua senha. Se não foi você, ignore este email.</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $resetUrl }}" class="btn-primary">Redefinir Senha</a>
    </div>

    <p style="font-size: 12px; color: #777; margin-top: 20px;">
        Ou copie o link no seu navegador:<br>
        <a href="{{ $resetUrl }}" style="color: #555; word-break: break-all;">{{ $resetUrl }}</a>
    </p>
@endsection
