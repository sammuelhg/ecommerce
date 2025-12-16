<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Test</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="font-sans antialiased bg-light p-5">
    <div class="container pb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Teste de Exibição de Formulários</h1>
            <div>
                <span class="me-2">Modo:</span>
                <div class="btn-group" role="group">
                    <a href="?mode=inline" class="btn btn-{{ request('mode', 'inline') == 'inline' ? 'primary' : 'outline-primary' }}">Comum (Inline)</a>
                    <a href="?mode=modal" class="btn btn-{{ request('mode') == 'modal' ? 'primary' : 'outline-primary' }}">Modal</a>
                </div>
            </div>
        </div>
        
        <div class="row g-5">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm p-4">
                    <h3>Visualização: {{ request('mode', 'inline') == 'modal' ? 'Modal (Popup)' : 'Comum (Inline)' }}</h3>
                    <p class="text-muted mb-4">Abaixo está o componente <code>UniversalForm</code> renderizado com a configuração selecionada.</p>
                    
                    <div class="border p-3 rounded bg-white d-flex justify-content-center align-items-center" style="min-height: 200px;">
                        @php
                            $settings = [];
                            if (request('mode') == 'modal') {
                                $settings = [
                                    'display_type' => 'modal',
                                    'trigger_text' => 'Abrir Promoção Especial',
                                ];
                            } else {
                                $settings = [
                                    'display_type' => 'inline',
                                ];
                            }
                        @endphp

                        @livewire('cms.universal-form', ['slug' => 'pos', 'settings' => $settings])
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>
