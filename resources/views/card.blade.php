<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cards Digitais - {{ config('app.name') }}</title>
  
  <link rel="stylesheet" href="{{ asset('css/card-styles.css') }}">
  <style>
    /* Minimal overrides if necessary, or empty */
    body {
        padding: 2rem;
        min-height: 100vh;
        background-color: #eef1f5;
    }
    .page-title {
        text-align: center;
        margin-bottom: 2rem;
        font-family: 'Segoe UI', sans-serif;
    }
    .cards-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        max-width: 1200px;
        margin: 0 auto;
    }
  </style>
</head>
<body>

<h1 class="page-title">Cards Digitais</h1>

@php
    // Updated to use Unified Data Source (SignCard)
    // Was: $cards = \App\Models\EmailCard::active()->get();
    $cards = \App\Models\SignCard::all(); 
@endphp

@if($cards->count() > 0)
<div class="cards-grid">
  @foreach($cards as $card)
    <div style="margin-bottom: 2rem;">
        <x-email.digital-card :card="$card" />
    </div>
  @endforeach
</div>
@else
<div class="empty-state">
  <h2>Nenhum card cadastrado</h2>
  <p>Acesse o painel administrativo para criar cards.</p>
</div>
@endif

</body>
</html>
