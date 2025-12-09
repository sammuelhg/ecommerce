@extends('emails.layouts.global')

@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center">
                <!-- Card Container -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 1px solid #eee;">
                    <!-- Image -->
                    <tr>
                        <td style="padding: 0;">
                            @if($data->imageUrl)
                                <img src="{{ $data->imageUrl }}" alt="{{ $data->title }}" style="width: 100%; height: auto; display: block; border-bottom: 4px solid #FFD600;">
                            @else
                                <div style="width: 100%; height: 200px; background: linear-gradient(45deg, #FFD600, #FF0069); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold;">
                                    LosFit
                                </div>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px; text-align: center;">
                            <h2 style="color: #1a1a1a; margin-top: 0; margin-bottom: 15px; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">{{ $data->title }}</h2>
                            <p style="color: #666666; font-size: 16px; line-height: 1.6; margin-bottom: 25px;">{{ $data->subtitle }}</p>
                            
                            <!-- CTA Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $data->ctaUrl }}" style="display: inline-block; padding: 14px 30px; background-color: #1a1a1a; color: #ffffff; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 16px; transition: background 0.3s;">
                                            {{ $data->ctaText }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <!-- Optional Items List -->
        @if(!empty($data->items))
            <tr>
                <td style="padding-top: 30px;">
                    <h3 style="text-align: center; color: #999; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Também pode gostar</h3>
                </td>
            </tr>
            @foreach($data->items as $item)
                <tr>
                    <td align="center" style="padding: 10px;">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 480px; background: #f8f9fa; border-radius: 8px; padding: 10px;">
                            <tr>
                                <td width="60">
                                    <img src="{{ $item['image'] ?? '' }}" alt="" style="width: 50px; height: 50px; border-radius: 6px; object-fit: cover;">
                                </td>
                                <td style="padding-left: 15px;">
                                    <strong style="display: block; color: #333;">{{ $item['name'] }}</strong>
                                    <span style="color: #FF0069; font-weight: bold;">{{ $item['price'] }}</span>
                                </td>
                                <td align="right">
                                    <a href="{{ $item['url'] }}" style="color: #1a1a1a; text-decoration: none; font-size: 14px; border: 1px solid #ddd; padding: 5px 12px; border-radius: 20px;">Ver</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
        @endif
        
    </table>
@endsection
