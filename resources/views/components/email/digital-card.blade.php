@props([
    'card' => null, 
    'senderName' => null, 
    'senderRole' => null, 
    'photo' => null, 
    'logo' => null, 
    'instagram' => null, 
    'whatsapp' => null, 
    'website' => null, 
    'slogan' => null
])

@php
    // Normalization Logic for different models (EmailCard vs SignCard)
    if ($card) {
        $senderName = $senderName ?? ($card->sender_name ?? $card->name); // User might pass name (SignCard) or sender_name (EmailCard)
        $senderRole = $senderRole ?? ($card->sender_role ?? $card->role);
        $photo = $photo ?? ($card->photo ?? $card->avatar_url);
        $instagram = $instagram ?? $card->instagram;
        $whatsapp = $whatsapp ?? $card->whatsapp;
        $website = $website ?? $card->website;
        $slogan = $slogan ?? $card->slogan;
    }

    // Default Fallbacks
    $senderName = $senderName ?? 'LosFit Team';
    $senderRole = $senderRole ?? 'Suporte';
    $website = $website ?? 'www.losfit.com.br';
    $slogan = $slogan ?? 'Saúde • Foco • Resultado';
    
    // Determining Image URLs
    $baseUrl = url('/'); 
    
    // Photo URL
    $photoUrl = null;
    if ($photo) {
        // Check if it's already a full URL or relative path
        $photoUrl = preg_match('/^http/', $photo) ? $photo : url($photo);
    }

    // Logo URL fallback
    $logoUrl = $logo ? (preg_match('/^http/', $logo) ? $logo : url($logo)) : url('email-assets/logo.png');
@endphp

<!-- Unified Digital Card Component (Div-Based) -->
<!-- Matches source of truth: resources/views/card.blade.php -->
<div class="custom-card">
    <div class="card-main-content">
      <!-- Image Section (Left) -->
      <div class="card-image-section">
        @if($photoUrl)
          <img src="{{ $photoUrl }}" alt="{{ $senderName }}" class="photo">
        @else
          <img src="{{ $logoUrl }}" alt="Logo" class="logo">
        @endif
      </div>
      
      <!-- Text Section (Right) -->
      <div class="card-text-section">
        <h2 class="card-title">{{ $senderName }}</h2>
        <p class="card-subtitle">{{ $senderRole }}</p>

        <div class="contact-list">
          @if($instagram)
          <div class="contact-item">
            <img src="{{ asset('email-assets/instagram-icon.svg') }}" alt="Instagram">
            <a href="https://www.instagram.com/{{ ltrim($instagram, '@') }}" target="_blank" class="contact-link">{{ '@' . ltrim($instagram, '@') }}</a>
          </div>
          @endif

          @if($whatsapp)
          <div class="contact-item">
             <!-- Fixed WhatsApp icon path as requested -->
            <img src="{{ asset('email-assets/WhatsApp.svg') }}" alt="WhatsApp">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" class="contact-link">{{ $whatsapp }}</a>
          </div>
          @endif
          
          @if($website)
          <div class="contact-item">
            <img src="{{ asset('email-assets/globe.svg') }}" alt="Website" style="width: 16px; height: 16px;">
            <a href="https://{{ $website }}" target="_blank" class="contact-link">{{ $website }}</a>
          </div>
          @endif
        </div>
        
        <!-- Logo in bottom right corner (only if card has photo) -->
        @if($photoUrl)
          <img src="{{ asset('email-assets/logo.png') }}" alt="Logo" class="card-logo-corner">
        @endif
      </div>

    </div>

    <div class="card-footer">
      {{ $slogan }}
    </div>
</div>
