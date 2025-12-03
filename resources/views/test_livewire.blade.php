<!doctype html>
<html>
<head>
    <title>Test Livewire</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <h1>Test Livewire Isolation</h1>
    
    @livewire('admin.product-form')
    
    @livewireScripts
    
    <script>
        console.log('Test Page Loaded');
        document.addEventListener('livewire:init', () => {
            console.log('Livewire Initialized', window.Livewire);
        });
    </script>
</body>
</html>
