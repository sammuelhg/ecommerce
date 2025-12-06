<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>{{ $subject ?? 'LosFit' }}</title>
<style type="text/css">
  /* Reset básico */
  body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
  table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
  img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
  table { border-collapse: collapse !important; }
  body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
  body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #eef1f5; }
  
  /* Botões */
  .btn-primary {
      background-color: #000000;
      color: #ffffff !important;
      padding: 12px 24px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-block;
      font-weight: bold;
      font-size: 14px;
      text-transform: uppercase;
  }
  .btn-primary:hover { background-color: #333333; }
</style>
</head>
<body style="margin: 0; padding: 0; background-color: #eef1f5;">

@php
    // Get settings
    $emailSettings = \App\Models\StoreSetting::all()->pluck('value', 'key');
    
    // Get selected card from settings, or default card
    $selectedCardId = $emailSettings['email_card_id'] ?? null;
    $emailCard = $selectedCardId 
        ? \App\Models\EmailCard::find($selectedCardId) 
        : \App\Models\EmailCard::getDefault();
    
    // Use card data or fallback
    if ($emailCard) {
        $senderName = $emailCard->sender_name;
        $senderRole = $emailCard->sender_role;
        $instagram = $emailCard->instagram;
        $website = $emailCard->website;
        $slogan = $emailCard->slogan;
    } else {
        $senderName = 'Jacqueline Maria Bergsten';
        $senderRole = 'CEO';
        $instagram = 'losfit1000';
        $website = 'www.losfit.com.br';
        $slogan = 'Saúde • Foco • Resultado';
    }
    
    // Base URL for email assets
    $emailAssetsUrl = config('app.url') . '/email-assets';
    
    // Get featured products for all emails
    $featuredProducts = $products ?? \App\Models\Product::where('is_active', true)->inRandomOrder()->take(3)->get();
@endphp

  <!-- Wrapper Principal -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #eef1f5; padding: 20px 0;">
    <tr>
      <td align="center" valign="top">
        
        <!-- Main Content Area (Above Card) -->
        <table border="0" cellpadding="0" cellspacing="0" width="550" align="center" style="background-color: transparent; border-radius: 6px; margin-bottom: 20px; max-width: 550px; width: 100%;">
            <tr>
                   <td valign="top" style="padding: 20px; font-family: 'Segoe UI', Arial, sans-serif; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                       @yield('content')
                       
                       <!-- Destaques para você (Standard in all emails) -->
                       @if($featuredProducts->count() > 0)
                           <div style="border-top: 1px solid #e0e0e0; margin: 30px 0 20px 0; width: 100%;"></div>
                           
                           <p style="color: #000; font-weight: 800; font-size: 14px; text-transform: uppercase; margin-bottom: 15px;">
                               Destaques para você
                           </p>

                           <table border="0" cellpadding="0" cellspacing="0" width="100%">
                               @foreach($featuredProducts as $product)
                               <tr>
                                   <td width="60" valign="top" style="padding-bottom: 15px;">
                                       @if($product->image)
                                           <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" width="50" height="50" style="border-radius: 6px; object-fit: cover; border: 1px solid #eee;">
                                       @else
                                           <div style="width: 50px; height: 50px; background-color: #eee; border-radius: 6px;"></div>
                                       @endif
                                   </td>
                                   <td valign="top" style="padding-bottom: 15px; padding-left: 10px;">
                                       <a href="{{ route('shop.show', $product->slug) }}" style="text-decoration: none; color: #000; font-weight: 600; font-size: 14px; display: block;">
                                           {{ $product->name }}
                                       </a>
                                       <span style="color: #555; font-size: 13px;">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                   </td>
                               </tr>
                               @endforeach
                           </table>
                       @endif
                   </td>
            </tr>
        </table>

        <!-- Espaçador -->
        <table border="0" cellpadding="0" cellspacing="0" width="550" align="center">
            <tr><td style="height: 20px;"></td></tr>
        </table>

        <!-- Cartão Central (Signature) -->
        <table border="0" cellpadding="0" cellspacing="0" width="550" align="center" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 550px; width: 100%;">
          <!-- Borda preta no topo -->
          <tr>
            <td colspan="2" style="background-color: #000000; height: 5px;"></td>
          </tr>
          
          <!-- Layout em Tabela: Coluna Imagem (Esquerda) e Coluna Texto (Direita) -->
          <tr>
            <!-- Coluna da Logo -->
            <td width="180" valign="middle" align="center" style="background-color: #f9f9f9; padding: 10px; border-right: 1px solid #eeeeee;">
              <a href="https://{{ $website }}" target="_blank" style="text-decoration: none;">
                <img src="{{ $emailAssetsUrl }}/logo.png" alt="LosFit Logo" width="170" style="display: block; width: 170px; max-width: 100%; border: 0;" border="0">
              </a>
            </td>

            <!-- Coluna de Texto -->
            <td valign="middle" style="padding: 30px;">
              
              <!-- Nome e Cargo -->
              <h1 style="margin: 0; color: #000000; font-size: 18px; font-weight: 800; text-transform: uppercase; letter-spacing: -0.5px; line-height: 1.2;">
                {{ $senderName }}
              </h1>
              <p style="margin: 5px 0 15px 0; color: #555555; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">
                {{ $senderRole }}
              </p>

              <!-- Linha Divisória -->
              <div style="border-top: 1px solid #e0e0e0; margin-bottom: 20px; width: 100%;"></div>

              <!-- Links de Contato -->
              
              <!-- Instagram -->
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 12px;">
                <tr>
                  <td width="30" valign="middle">
                    <img src="{{ config('app.url') }}/Instagram_logo.svg" alt="IG" width="24" height="24" style="display: block; width: 24px; height: 24px; border: 0;" />
                  </td>
                  <td valign="middle">
                    <span style="font-size: 11px; color: #777777; display: block; line-height: 1;">Siga-nos no Instagram</span>
                    <a href="https://www.instagram.com/{{ ltrim($instagram, '@') }}" target="_blank" style="color: #000000; text-decoration: none; font-weight: 700; font-size: 14px;">
                      {{ '@' . ltrim($instagram, '@') }}
                    </a>
                  </td>
                </tr>
              </table>

              <!-- Website -->
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td width="30" valign="middle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16" fill="#000000">
                      <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
                    </svg>
                  </td>
                  <td valign="middle" style="padding-left: 5px;">
                    <a href="https://{{ $website }}" target="_blank" style="color: #333333; text-decoration: none; font-weight: 600; font-size: 14px;">
                      {{ $website }}
                    </a>
                  </td>
                </tr>
              </table>

            </td>
          </tr>
          
          <!-- Rodapé -->
          <tr>
            <td colspan="2" align="center" style="background-color: #000000; padding: 12px; color: #ffffff; font-size: 11px; font-weight: 500; letter-spacing: 0.5px;">
              {{ $slogan }}
            </td>
          </tr>

        </table>
        
        <!-- Copyright -->
        <table border="0" cellpadding="0" cellspacing="0" width="600">
            <tr>
                <td align="center" style="padding-top: 15px; color: #999999; font-family: Arial, sans-serif; font-size: 10px;">
                    © {{ date('Y') }} LosFit. Todos os direitos reservados.
                </td>
            </tr>
        </table>

      </td>
    </tr>
  </table>

</body>
</html>

