<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Links - LosFit1000</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #000000;
            --secondary: #ffffff;
            --accent: #ffd700;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(-45deg, #fff5eb, #ffe4e1, #e6f2ff, #e0f7fa, #f0fff0, #e8fff5);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            width: 100%;
            max-width: 480px;
            padding: 40px 20px;
            text-align: center;
            box-sizing: border-box;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--secondary);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            background-color: #fff;
            padding: 10px;
        }

        .title {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 14px;
            color: #000;
            margin: 0 0 30px 0;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .links-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
        }

        .link-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--secondary);
            color: var(--primary);
            text-decoration: none;
            padding: 18px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #000;
            position: relative;
            gap: 12px;
        }

        .link-icon {
            position: absolute;
            left: 24px;
            font-size: 22px;
        }

        .link-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            border-color: var(--primary);
        }

        .link-btn.highlight {
            background-color: var(--primary);
            color: var(--secondary);
        }

        .link-btn.highlight:hover {
            background-color: #333;
            border-color: #333;
        }

        .link-btn svg {
            width: 24px;
            height: 24px;
            position: absolute;
            left: 20px;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #000;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .social-icon {
            color: var(--primary);
            transition: transform 0.2s;
        }

        .social-icon:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Logo/Foto -->
        <img src="https://losfit.com.br/logo-redonda-trans.png" 
             onerror="this.src='https://losfit.com.br/logo-email.png'" 
             alt="LosFit Logo" 
             class="profile-img">

        @php
            $pageTitle = \App\Models\StoreSetting::get('links_page_title', 'LosFit 1000');
            $pageSubtitle = \App\Models\StoreSetting::get('links_page_subtitle', 'Performance & Lifestyle');
            $links = \App\Models\LinkItem::active()->ordered()->get();
        @endphp

        <h1 class="title">{{ $pageTitle }}</h1>
        <p class="subtitle">{{ $pageSubtitle }}</p>

        <div class="links-container">
            
            @forelse($links as $link)
                <a href="{{ $link->url }}" class="link-btn" target="_blank" style="{{ $link->color_style }}">
                    @if($link->icon)
                        <span class="link-icon">{!! $link->icon !!}</span>
                    @endif
                    {{ $link->title }}
                </a>
            @empty
                <p style="color: #666; text-align: center;">Links em breve...</p>
            @endforelse
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} LosFit. Todos os direitos reservados.</p>
        </div>
    </div>

</body>
</html>
