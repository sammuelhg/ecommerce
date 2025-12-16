<x-mail::message>
# Olá, {{ $leadName }}!

Vimos que você demonstrou interesse em nossos produtos. 

Estamos com uma condição especial para você fechar sua compra hoje.

<x-mail::button :url="route('shop.index')">
Ver Ofertas
</x-mail::button>

Qualquer dúvida, responda este email.

Atenciosamente,<br>
Equipe {{ config('app.name') }}
</x-mail::message>
