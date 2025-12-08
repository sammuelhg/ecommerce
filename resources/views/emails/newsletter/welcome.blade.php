@extends('emails.layout')

@section('content')
    <h1 style="color: #000; font-size: 24px; font-weight: 800; margin-bottom: 20px;">Bem-vindo(a) à LosFit!</h1>

    <p style="color: #555; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
        Obrigado por se inscrever em nossa newsletter. Como prometido, aqui está o seu cupom de <strong>15% de desconto</strong> para sua primeira compra:
    </p>

    <!-- Coupon Panel -->
    <div style="background-color: #f8f9fa; border: 2px dashed #000; border-radius: 8px; padding: 20px; text-align: center; margin-bottom: 30px;">
        <span style="display: block; font-size: 14px; text-transform: uppercase; color: #777; margin-bottom: 5px;">Seu Cupom:</span>
        <strong style="font-size: 28px; color: #000; letter-spacing: 2px;">WELCOME15</strong>
    </div>

    <p style="color: #555; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">
        Aproveite nossas ofertas exclusivas e novidades quentinhas em nossa loja.
    </p>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ url('/shop') }}" class="btn-primary" style="color: #ffffff !important;">
            Ir para a Loja
        </a>
    </div>
@endsection
