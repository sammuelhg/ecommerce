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
  
  @media only screen and (max-width: 480px) {
      .main-content { padding: 10px !important; }
      .wrapper { padding: 10px 0 !important; }
  }

  /* EMAIL CARD STYLES (Injected) */
  :root {
      --brand-primary: #000000;
      --text-color-dark: #1a1a1a;
      --text-color-light: #555555;
      --background-color: #eef1f5;
  }

  .custom-card {
      background-color: #ffffff;
      width: 340px;
      height: 200px;
      border-radius: 16px;
      border-top: 5px solid #000000; /* var(--brand-primary) fallback */
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      margin: 0 auto;
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
      color: #000000;
      line-height: 1.2;
  }

  .card-subtitle {
      font-size: 9px;
      color: #555555;
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
      color: #1a1a1a;
      text-decoration: none;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }

  .custom-card .card-footer {
      background-color: #000000;
      color: #ffffff;
      padding: 6px;
      padding-top: 8px; /* Adjustment for visuals */
      text-align: center;
      font-size: 10px;
      font-style: italic;
      width: 100%;
  }
</style>
</head>
<body style="margin: 0; padding: 0; background-color: #eef1f5;">

@inject('emailConfig', 'App\Settings\EmailConfigSettings')
@php
    // fetch Card (Prioritize override from Preview/Builder)
    if (isset($overrideCard) && $overrideCard) {
        $emailCard = $overrideCard;
    } else {
        $emailCard = $emailConfig->getDefaultEmailCard();
    }
    
    // Fallback data
    if ($emailCard) {
        $senderName = $emailCard->name; // SignCard field
        $senderRole = $emailCard->role; // SignCard field
        $instagram = $emailCard->instagram;
        $website = $emailCard->website;
        $slogan = $emailCard->slogan;
        
        // Handle Photo URL
        $photo = $emailCard->avatar_url; // SignCard field
        if (!$photo) {
            $photoUrl = null;
        } elseif (preg_match('/^http/', $photo)) {
            $photoUrl = $photo;
        } elseif (str_starts_with($photo, 'uploads/')) {
             $photoUrl = url($photo);
        } else {
             $photoUrl = asset('storage/' . $photo);
        }
    } else {
        $senderName = 'LosFit Team';
        $senderRole = 'Suporte';
        $instagram = 'losfit';
        $website = 'www.losfit.com.br';
        $slogan = 'Saúde • Foco • Resultado';
        $photoUrl = null;
    }
    
    // Showcase Products
    if (isset($overrideProducts)) {
         $featuredProducts = $overrideProducts;
    } else {
        $showcaseIds = $emailConfig->getShowcaseProductIds();
        // If no specific IDs set, fallback to random active products
        if (!empty($showcaseIds)) {
            $showcaseIds = array_slice($showcaseIds, 0, 3);
            $featuredProducts = \App\Domains\Catalog\Models\Product::whereIn('id', $showcaseIds)->get();
        } else {
            // Fallback: 3 random active products if no specific showcased ones
            $featuredProducts = \App\Domains\Catalog\Models\Product::where('is_active', true)->inRandomOrder()->take(3)->get();
        }
    }

    // Logo Logic
    $storeLogo = \App\Domains\Shared\Models\StoreSetting::get('email_logo') ?? \App\Domains\Shared\Models\StoreSetting::get('store_logo');
    if ($storeLogo) {
        $logoUrl = preg_match('/^http/', $storeLogo) ? $storeLogo : url($storeLogo);
    } else {
        $logoUrl = url('email-assets/logo.png'); // Fallback
    }
@endphp

  <!-- Wrapper Principal -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper" style="background-color: #eef1f5; padding: 20px 0;">
    <tr>
      <td align="center" valign="top">
        
        <!-- Main Content Area -->
        <table border="0" cellpadding="0" cellspacing="0" align="center" style="background-color: transparent; border-radius: 6px; margin: 0 auto; max-width: 550px; width: 100%;">
            <tr>
                   <td valign="top" class="main-content" style="padding: 20px; font-family: 'Segoe UI', Arial, sans-serif; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                       @yield('content')
                       
                       <!-- Destaques -->
                       @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                           <!-- ... (existing code) ... -->
                           <div style="border-top: 1px solid #e0e0e0; margin: 30px 0 20px 0; width: 100%;"></div>
                           
                           <p style="color: #000; font-weight: 800; font-size: 14px; text-transform: uppercase; margin-bottom: 20px; text-align: center;">
                               Destaques para você
                           </p>

                            <!-- Products Grid/Cards (LIST VIEW) -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                @foreach($featuredProducts as $index => $product)
                                <tr>
                                    <td valign="top" style="padding-bottom: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 1px solid #f0f0f0; padding-bottom: 20px;">
                                            <tr>
                                                <!-- Image Column (Left) -->
                                                <td width="100" valign="top">
                                                     <a href="{{ route('shop.show', $product->slug) }}" style="display: block; text-decoration: none;">
                                                        @if($product->image)
                                                            @php
                                                                $imgSrc = $product->image;
                                                                if (!preg_match('/^http/', $imgSrc)) {
                                                                    $imgSrc = \Illuminate\Support\Facades\Storage::url($imgSrc);
                                                                    $imgSrc = url($imgSrc);
                                                                }
                                                            @endphp
                                                            <img src="{{ $imgSrc }}" width="100" height="100" style="display: block; border-radius: 8px; object-fit: cover;">
                                                        @else
                                                            <div style="background-color: #eee; width: 100px; height: 100px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 10px;">
                                                                No Image
                                                            </div>
                                                        @endif
                                                    </a>
                                                </td>
                                                
                                                <!-- Details Column (Right) -->
                                                <td valign="top" style="padding-left: 15px;">
                                                    <a href="{{ route('shop.show', $product->slug) }}" style="text-decoration: none; color: #000; font-weight: 700; font-size: 14px; display: block; margin-bottom: 5px; line-height: 1.3;">
                                                        {{ $product->name }}
                                                    </a>
                                                    
                                                    <div style="margin-bottom: 8px;">
                                                        @if($product->old_price)
                                                             <span style="color: #999; text-decoration: line-through; margin-right: 6px; font-size: 12px;">R$ {{ number_format($product->old_price, 2, ',', '.') }}</span>
                                                        @endif
                                                        <span style="color: #000; font-weight: 700; font-size: 15px;">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                                    </div>

                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td align="center" bgcolor="#000000" style="border-radius: 4px;">
                                                                <a href="{{ route('shop.show', $product->slug) }}" style="font-size: 11px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; padding: 6px 12px; border-radius: 4px; border: 1px solid #000000; display: inline-block; font-weight: bold; text-transform: uppercase;">
                                                                    Ver Oferta
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                       @elseif(isset($overrideProducts))
                           <!-- DEBUG STATE for Preview -->
                           <div style="border-top: 1px dashed #ccc; margin: 30px 0; padding: 20px; text-align: center; color: #999; font-size: 12px;">
                               <p>Nenhum produto selecionado para este passo.</p>
                               <p>Se você selecionou produtos agora, clique em <strong>Salvar</strong> antes de visualizar.</p>
                           </div>
                       @endif
                   </td>
            </tr>
        </table>

        <!-- Espaçador -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="max-width: 550px;">
            <tr><td style="height: 20px;"></td></tr>
        </table>

        <!-- Signature Card Component -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
            <tr>
                <td align="center">
                    <x-email.digital-card 
                        :senderName="$senderName"
                        :senderRole="$senderRole"
                        :photo="$photoUrl"
                        :logo="$logoUrl"
                        :instagram="$instagram"
                        :website="$website"
                        :slogan="$slogan"
                        :whatsapp="$emailCard->whatsapp ?? null"
                        :isEmail="true"
                    />
                </td>
            </tr>
        </table>

        <!-- Copyright -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" style="padding-top: 20px; color: #999999; font-family: Arial, sans-serif; font-size: 11px;">
                    @php
                        // Ensure we have a subscriber ID. 
                        // If not available (e.g. preview mode), use 0 or handle gracefully.
                        // $subscriber is passed from Mailable views extending this.
                        $subId = isset($subscriber) ? $subscriber->id : 0;
                        $actionUrl = $subId ? \Illuminate\Support\Facades\URL::signedRoute('newsletter.unsubscribe', ['subscriber' => $subId]) : '#';
                    @endphp
                    © {{ date('Y') }} LosFit. Todos os direitos reservados.<br>
                    @if($subId)
                        <a href="{{ $actionUrl }}" style="color: #999; text-decoration: underline;">Cancelar inscrição</a>
                    @endif
                </td>
            </tr>
        </table>

      </td>
    </tr>
  </table>

</body>
</html>
