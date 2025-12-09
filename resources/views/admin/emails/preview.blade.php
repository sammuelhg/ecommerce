@extends('layouts.admin')

@section('title', 'Email Previews')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="h4 fw-bold mb-1">Galeria de Templates</h2>
            <p class="text-muted small mb-0">Visualize como seus emails chegam ao cliente.</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.emails.preview.type', 'welcome') }}" class="btn btn-outline-secondary {{ request()->is('*welcome') ? 'active' : '' }}">Boas-vindas</a>
            <a href="{{ route('admin.emails.preview.type', 'reset') }}" class="btn btn-outline-secondary {{ request()->is('*reset') ? 'active' : '' }}">Senha</a>
            <a href="{{ route('admin.emails.preview.type', 'highlights') }}" class="btn btn-outline-secondary {{ request()->is('*highlights') ? 'active' : '' }}">Destaques</a>
            <a href="{{ route('admin.emails.preview.type', 'newsletter-welcome') }}" class="btn btn-outline-secondary {{ request()->is('*newsletter-welcome') ? 'active' : '' }}">News Welcome</a>
        </div>
    </div>

    @if(isset($cards) && count($cards) > 0)
        <h5 class="mb-4 text-secondary border-bottom pb-2">Assinaturas Digitais</h5>
        <div class="row g-4 mb-5">
            @foreach($cards as $card)
                <div class="col-md-6 col-lg-4 d-flex justify-content-center">
                    <x-email.digital-card :card="$card" />
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($showReply) && $showReply)
        <div class="card shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-header bg-light">
                <strong>Simulação de Resposta</strong>
            </div>
            <div class="card-body">
                <div class="mb-3 pb-3 border-bottom">
                    <strong>Assunto:</strong> {{ $replyPreview['subject'] }}
                </div>
                <div class="email-body">
                    {!! nl2br(e($replyPreview['body'])) !!}
                </div>
                
                @php $cardToUse = $defaultCard ?? \App\Models\EmailCard::getDefault(); @endphp
                @if($cardToUse)
                    <div class="mt-4 pt-4 border-top">
                        <x-email.digital-card :card="$cardToUse" :isEmail="true" />
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if(isset($showUnsubscribe) && $showUnsubscribe)
        <div class="card shadow-sm mx-auto text-center p-5" style="max-width: 500px;">
            <div class="text-danger mb-3">
                <i class="bi bi-x-circle display-1"></i>
            </div>
            <h3 class="fw-bold mb-3">Inscrição Cancelada</h3>
            @foreach($unsubScenarios as $scenario)
                <div class="alert alert-light border">
                    <p class="mb-1 text-muted small">Campanha</p>
                    <strong>{{ $scenario['campaign_name'] }}</strong>
                </div>
            @endforeach
            
            @if(isset($defaultCard) && $defaultCard)
                <div class="mt-4 text-start d-flex justify-content-center">
                    <x-email.digital-card :card="$defaultCard" :isEmail="true" />
                </div>
            @endif
        </div>
    @endif
    
    <!-- Empty State -->
    @if(empty($cards) && !isset($showReply) && !isset($showUnsubscribe))
        <div class="text-center py-5">
            <i class="bi bi-palette display-1 text-light"></i>
            <p class="text-muted mt-3">Selecione um tipo de email acima para visualizar.</p>
        </div>
    @endif

</div>
@endsection
