@extends('emails.layouts.global')

@section('content')
    <!-- Standardized Card Container -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <tr>
            <td style="padding: 40px;">
                <h1 style="color: #000; font-size: 24px; font-weight: 800; margin-top: 0; margin-bottom: 20px; text-align: center;">Bem-vindo(a) à LosFit!</h1>

                <p style="color: #555; font-size: 16px; line-height: 1.6; margin-bottom: 25px; text-align: center;">
                    Obrigado por se inscrever em nossa newsletter. Como prometido, aqui está o seu cupom de <strong>15% de desconto</strong> para sua primeira compra:
                </p>

                <!-- Coupon Panel -->
                <div style="background-color: #f8f9fa; border: 2px dashed #000; border-radius: 12px; padding: 25px; text-align: center; margin-bottom: 30px;">
                    <span style="display: block; font-size: 13px; text-transform: uppercase; color: #777; margin-bottom: 8px; font-weight: 600;">Seu Cupom Exclusivo</span>
                    <strong style="font-size: 32px; color: #000; letter-spacing: 3px; font-family: monospace;">WELCOME15</strong>
                </div>

                <p style="color: #555; font-size: 16px; line-height: 1.6; margin-bottom: 30px; text-align: center;">
                    Aproveite nossas ofertas exclusivas e novidades quentinhas em nossa loja.
                </p>

                <div style="text-align: center;">
                    <a href="{{ url('/shop') }}" class="btn-primary" style="display: inline-block; padding: 14px 35px; background-color: #000; color: #ffffff !important; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 16px;">
                        Ir para a Loja
                    </a>
                </div>
            </td>
        </tr>
    </table>
@endsection
