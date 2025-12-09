@extends('emails.layouts.global')

@section('content')
    <div style="text-align: center;">
        <p style="font-size: 18px; font-weight: bold; margin-top: 0; color: #28a745;">✅ Senha Alterada!</p>
        
        <p>Sua senha foi redefinida com sucesso.</p>

        @if($newPassword)
        <div style="background-color: #d4edda; padding: 15px; border-radius: 8px; margin: 15px auto; border-left: 3px solid #28a745; max-width: 300px; text-align: left;">
            <p style="margin: 5px 0; font-size: 14px; color: #155724;"><strong>Nova Senha:</strong> {{ $newPassword }}</p>
        </div>
        @endif

        <div style="margin-top: 30px;">
            <a href="{{ $loginUrl }}" class="btn-primary">Fazer Login</a>
        </div>
    </div>
@endsection
