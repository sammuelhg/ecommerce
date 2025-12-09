@props(['card' => null, 'senderName' => null, 'senderRole' => null, 'photo' => null, 'logo' => null, 'instagram' => null, 'whatsapp' => null, 'website' => null, 'slogan' => null, 'isEmail' => false])

@php
    // If a full card object is passed, extract data from it
    if ($card) {
        $senderName = $card->sender_name;
        $senderRole = $card->sender_role;
        $photo = $card->photo;
        $instagram = $card->instagram;
        $whatsapp = $card->whatsapp;
        $website = $card->website;
        $slogan = $card->slogan;
    }

    // Default Fallbacks
    $senderName = $senderName ?? 'LosFit Team';
    $senderRole = $senderRole ?? 'Suporte';
    $website = $website ?? 'www.losfit.com.br';
    $slogan = $slogan ?? 'Saúde • Foco • Resultado';
    
    // Determining Image URLs
    // logic: if 'http' in string, use as is. Else if 'isEmail' use absolute url(). Else use asset().
    // Actually, for consistency between Web and Email, we SHOULD always use full URL, but asset() is cleaner for local dev if image is missing.
    // Let's use url() everywhere to ensure it works in Emails (primary use case).

    $baseUrl = url('/'); 
    
    // Photo URL
    $photoUrl = null;
    if ($photo) {
        // Check if it's already a full URL or relative path
        $photoUrl = preg_match('/^http/', $photo) ? $photo : url($photo);
        // Correct common path issues if stored without 'uploads/' prefix but expected there?
        // Livewire upload often stores in 'email-cards/filename'. Asset helper usually points to public folder.
        // Let's trust the passing controller logic or raw DB value to be relative to public root OR full URL.
        // Fix: If explicitly raw DB value like "email-cards/xyz.jpg", url() makes "http://host/email-cards/xyz.jpg". Perfect.
    }

    // Logo URL fallback
    $logoUrl = $logo ? (preg_match('/^http/', $logo) ? $logo : url($logo)) : url('email-assets/logo.png');

@endphp

<!-- Digital Card Component -->
@if($isEmail)
    <!-- EMAIL VERSION (Table-Based, Inline Styles) -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 340px; width: 100%; margin: 0 auto; border-collapse: separate; font-family: 'Segoe UI', Arial, sans-serif;">
      
      <!-- Top Border (Brand Primary) -->
      <tr>
        <td colspan="2" height="5" style="background-color: #000000; font-size: 0; line-height: 0;">&nbsp;</td>
      </tr>
      
      <tr>
        <!-- Image Section (Left) - Exact 120px width, NO padding -->
        <td width="120" valign="middle" align="center" bgcolor="#f9f9f9" style="background-color: #f9f9f9; padding: 0; border-right: 1px solid #eeeeee; width: 120px;">
          <div style="width: 120px; height: 165px; display: block; overflow: hidden;">
              @if($photoUrl)
                   <img src="{{ $photoUrl }}" alt="{{ $senderName }}" width="120" height="165" style="display: block; width: 120px; height: 165px; object-fit: cover; border: 0;">
              @else
                   <img src="{{ $logoUrl }}" alt="LosFit" width="90" style="display: block; width: 90px; max-width: 80%; margin: 40px auto; border: 0;">
              @endif
          </div>
        </td>

        <!-- Text Section (Right) - Relative positioning simulation -->
        <td valign="middle" style="padding: 12px 14px; vertical-align: middle; position: relative;">
          
          <!-- Title -->
          <h2 style="margin: 0 0 2px 0; color: #000000; font-size: 14px; font-weight: 800; text-transform: uppercase; line-height: 1.2; font-family: 'Segoe UI', Arial, sans-serif;">
            {{ $senderName }}
          </h2>
          
          <!-- Subtitle -->
          <p style="margin: 0 0 10px 0; color: #555555; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px;">
            {{ $senderRole }}
          </p>

          <!-- Contacts -->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="position: relative; z-index: 2;">
             <!-- Instagram -->
             @if($instagram)
             <tr>
                <td width="18" style="padding-bottom: 4px;">
                    <img src="{{ url('Instagram_logo.svg') }}" width="14" height="14" style="display: block;">
                </td>
                <td style="padding-bottom: 4px;">
                    <a href="https://www.instagram.com/{{ ltrim($instagram, '@') }}" target="_blank" style="color: #1a1a1a; text-decoration: none; font-size: 11px; font-weight: 600;">
                        @ {{ ltrim($instagram, '@') }}
                    </a>
                </td>
             </tr>
             @endif

             <!-- WhatsApp (if set) -->
             @if($whatsapp)
             <tr>
                <td width="18" style="padding-bottom: 4px;">
                    <img src="{{ url('WhatsApp.svg') }}" width="14" height="14" style="display: block;">
                </td>
                <td style="padding-bottom: 4px;">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" style="color: #1a1a1a; text-decoration: none; font-size: 11px; font-weight: 600;">
                        {{ $whatsapp }}
                    </a>
                </td>
             </tr>
             @endif
             
             <!-- Website -->
             <tr>
                <td width="18">
                    <img src="{{ url('globe.svg') }}" width="14" height="14" style="display: block;">
                </td>
                <td>
                    <a href="https://{{ $website }}" target="_blank" style="color: #1a1a1a; text-decoration: none; font-size: 11px; font-weight: 600;">
                        {{ $website }}
                    </a>
                </td>
             </tr>
          </table>

          <!-- Corner Logo (Simulated for Email) -->
          @if($photoUrl)
          <div style="text-align: right; margin-top: -20px; padding-right: 0;">
             <img src="{{ url('email-assets/logo.png') }}" width="52" style="display: inline-block; opacity: 0.9; width: 52px; height: auto;">
          </div>
          @endif

        </td>
      </tr>
      
      <!-- Footer -->
      <tr>
        <td colspan="2" align="center" bgcolor="#000000" style="background-color: #000000; padding: 6px; color: #ffffff; font-size: 10px; font-style: italic;">
          {{ $slogan }}
        </td>
      </tr>

    </table>
@else
    <!-- WEB VERSION (Div-Based, uses external CSS classes) -->
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
                <img src="{{ asset('Instagram_logo.svg') }}" alt="Instagram">
                <a href="https://www.instagram.com/{{ ltrim($instagram, '@') }}" target="_blank" class="contact-link">{{ '@' . ltrim($instagram, '@') }}</a>
              </div>
              @endif

              @if($whatsapp)
              <div class="contact-item">
                <img src="{{ asset('WhatsApp.svg') }}" alt="WhatsApp">
                <a href="https://wa.me/55{{ $whatsapp }}" target="_blank" class="contact-link">{{ $whatsapp }}</a>
              </div>
              @endif
              
              @if($website)
              <div class="contact-item">
                <img src="{{ asset('globe.svg') }}" alt="Website" style="width: 16px; height: 16px;">
                <a href="https://{{ $website }}" target="_blank" class="contact-link">{{ $website }}</a>
              </div>
              @endif
            </div>
          </div>

          <!-- Logo in bottom right corner (only if card has photo) -->
          @if($photoUrl)
            <img src="{{ asset('email-assets/logo.png') }}" alt="Logo" class="card-logo-corner">
          @endif
        </div>

        <div class="card-footer">
          {{ $slogan }}
        </div>
    </div>
@endif
