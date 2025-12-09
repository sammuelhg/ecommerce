<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cards Digitais - {{ config('app.name') }}</title>
  
  <style>
    :root {
      --brand-primary: #000000; 
      --text-color-dark: #1a1a1a;
      --text-color-light: #555555;
      --background-color: #eef1f5;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: var(--background-color);
      padding: 2rem;
      min-height: 100vh;
    }

    .page-title {
      text-align: center;
      font-size: 2rem;
      font-weight: 800;
      color: var(--brand-primary);
      margin-bottom: 2rem;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .cards-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: center;
      max-width: 1200px;
      margin: 0 auto;
    }

    .custom-card {
      background-color: #ffffff;
      width: 340px;
      height: 200px;
      border-radius: 16px;
      border-top: 5px solid var(--brand-primary);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .card-main-content {
      display: flex;
      flex-direction: row;
      flex: 1;
      position: relative;
    }

    .card-image-section {
      width: 120px;
      background-color: #f9f9f9;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .card-image-section img.photo {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .card-image-section img.logo {
      max-width: 100px;
      height: auto;
    }

    .card-logo-corner {
      position: absolute;
      bottom: 10px;
      right: 10px;
      width: 52px;
      opacity: 0.9;
    }

    .card-text-section {
      flex: 1;
      padding: 12px 14px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .card-title {
      font-size: 14px;
      font-weight: 800;
      text-transform: uppercase;
      margin: 0 0 2px 0;
      color: var(--brand-primary);
      line-height: 1.2;
    }

    .card-subtitle {
      font-size: 9px;
      color: var(--text-color-light);
      text-transform: uppercase;
      margin: 0 0 10px 0;
    }

    .contact-list {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .contact-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .contact-item img {
      width: 16px;
      height: 16px;
    }

    .contact-link {
      font-size: 11px;
      font-weight: 600;
      color: var(--text-color-dark);
      text-decoration: none;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .card-footer {
      background-color: var(--brand-primary);
      color: #ffffff;
      padding: 6px;
      text-align: center;
      font-size: 10px;
      font-style: italic;
    }

    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      color: var(--text-color-light);
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .custom-card { animation: fadeInUp 0.5s ease forwards; }
    .custom-card:nth-child(2) { animation-delay: 0.1s; }
    .custom-card:nth-child(3) { animation-delay: 0.2s; }
  </style>
</head>
<body>

<h1 class="page-title">Cards Digitais</h1>

@php
    $cards = \App\Models\EmailCard::active()->get();
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
