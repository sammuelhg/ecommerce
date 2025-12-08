@extends('emails.layout')

@section('content')
    <h1 style="color: #000; font-size: 24px; font-weight: 800; margin-bottom: 20px;">
        {{ $campaign->subject }}
    </h1>

    <div style="color: #555; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
        {!! nl2br(e($campaign->body)) !!}
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ url('/shop') }}" class="btn-primary" style="color: #ffffff !important;">
            Acessar Loja
        </a>
    </div>
@endsection
