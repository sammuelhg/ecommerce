@extends('emails.layouts.global')

@section('content')
    <div style="font-family: 'Segoe UI', Arial, sans-serif; color: #333333; line-height: 1.6;">
        {!! $content !!}
    </div>

    @if(isset($products) && $products->count() > 0)
        <div style="margin-top: 30px; border-top: 1px solid #eeeeee; padding-top: 20px;">
            <h3 style="color: #333; font-size: 18px; margin-bottom: 15px;">Destaques para você:</h3>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    @foreach($products as $index => $product)
                        @if($index > 0 && $index % 2 == 0)
                            </tr><tr>
                        @endif
                        <td width="50%" valign="top" style="padding: 10px;">
                            <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff;">
                                @if($product->image_url)
                                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" style="width: 100%; height: auto; display: block;">
                                @endif
                                <div style="padding: 15px;">
                                    <h4 style="margin: 0 0 10px; font-size: 16px; color: #000;">{{ $product->name }}</h4>
                                    <p style="margin: 0 0 15px; color: #666; font-size: 14px;">
                                        R$ {{ number_format($product->price, 2, ',', '.') }}
                                    </p>
                                    <a href="{{ route('shop.show', $product->slug) }}" style="display: block; background: #000; color: #fff; text-decoration: none; padding: 10px; text-align: center; border-radius: 4px; font-size: 14px;">
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </td>
                    @endforeach
                </tr>
            </table>
        </div>
    @endif

    @if(isset($overrideCard) && $overrideCard)
        <div style="margin-top: 40px; background: #f9f9f9; padding: 20px; border-radius: 8px; text-align: center;">
            @if($overrideCard->photo)
                <img src="{{ asset($overrideCard->photo) }}" alt="{{ $overrideCard->sender_name }}" style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 10px;">
            @endif
            <h3 style="margin: 0; font-size: 18px; color: #333;">{{ $overrideCard->sender_name }}</h3>
            @if($overrideCard->sender_role)
                <p style="margin: 5px 0 0; color: #777; font-size: 14px;">{{ $overrideCard->sender_role }}</p>
            @endif
            @if($overrideCard->slogan)
                <p style="margin: 15px 0 0; font-style: italic; color: #555;">"{{ $overrideCard->slogan }}"</p>
            @endif
            
            <div style="margin-top: 20px;">
                @if($overrideCard->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $overrideCard->whatsapp) }}" style="text-decoration: none; margin: 0 5px; color: #25D366;">WhatsApp</a>
                @endif
                @if($overrideCard->instagram)
                    <a href="{{ $overrideCard->instagram }}" style="text-decoration: none; margin: 0 5px; color: #E1306C;">Instagram</a>
                @endif
                @if($overrideCard->website)
                    <a href="{{ $overrideCard->website }}" style="text-decoration: none; margin: 0 5px; color: #007bff;">Site</a>
                @endif
            </div>
        </div>
    @endif

    <!-- Tracking Pixel -->
    <img src="{{ $trackingUrl }}" width="1" height="1" style="display:none;" alt="" />
@endsection
