<x-mail::message>
# Sentimos sua falta, {{ $leadName }}!

Faz um tempo que não vemos você por aqui. Como cliente especial, preparamos um cupom de retorno.

Use o cupom **RETORNO10** para 10% de desconto na sua próxima compra.

<x-mail::button :url="route('shop.index')">
Resgatar Cupom
</x-mail::button>

Atenciosamente,<br>
Equipe {{ config('app.name') }}
</x-mail::message>
