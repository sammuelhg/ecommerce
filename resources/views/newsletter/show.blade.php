@extends('emails.layouts.global')

@section('content')
    @if($campaign->emails->count() > 0)
        <!-- Exibindo o primeiro email da sequência (Imediato) -->
        {!! $campaign->emails->first()->body !!}
    @else
        <p style="text-align: center; color: #999;">Esta campanha ainda não possui emails configurados.</p>
    @endif
@endsection
