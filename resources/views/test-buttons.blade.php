<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metallic Gold Buttons Test</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            background-color: #111827; /* Dark background to see the gold pop */
            color: white;
            padding: 2rem;
        }
        .section {
            margin-bottom: 3rem;
            border-bottom: 1px solid #333;
            padding-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-5 text-center text-warning">Metallic Gold Theme Test</h1>

        <div class="section">
            <h2>Standard Bootstrap Buttons (.btn-warning)</h2>
            <p>These should automatically pick up the new variables.</p>
            <div class="d-flex gap-3 flex-wrap">
                <button class="btn btn-warning">Default Warning</button>
                <button class="btn btn-warning btn-lg">Large Warning</button>
                <button class="btn btn-warning btn-sm">Small Warning</button>
                <button class="btn btn-warning disabled">Disabled</button>
            </div>
        </div>

        <div class="section">
            <h2>Outline Buttons (.btn-outline-warning)</h2>
            <p>Custom outline style with dark inner background.</p>
            <div class="d-flex gap-3 flex-wrap">
                <button class="btn btn-outline-warning">Outline Warning</button>
                <button class="btn btn-outline-warning btn-lg">Large Outline</button>
                <button class="btn btn-outline-warning btn-sm">Small Outline</button>
            </div>
        </div>

        <div class="section">
            <h2>Animated Buttons (.btn-animated-effect)</h2>
            <p>Hover to see the "light sweep" effect.</p>
            <div class="d-flex gap-3 flex-wrap">
                <button class="btn btn-warning btn-animated-effect">Solid Animated</button>
                <button class="btn btn-outline-warning btn-animated-effect">Outline Animated</button>
            </div>
        </div>

        <div class="section">
            <h2>Shapes & Icons (.btn-icon-shape)</h2>
            <p>Perfect geometric shapes without deformation.</p>
            
            <div class="row g-4">
                <div class="col-auto">
                    <h4>Square (rounded-0)</h4>
                    <button class="btn btn-warning btn-icon-shape rounded-0">
                        <i class="bi bi-star-fill"></i>
                    </button>
                    <button class="btn btn-outline-warning btn-icon-shape rounded-0">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                </div>

                <div class="col-auto">
                    <h4>Circle (rounded-circle)</h4>
                    <button class="btn btn-warning btn-icon-shape rounded-circle">
                        <i class="bi bi-check-lg"></i>
                    </button>
                    <button class="btn btn-outline-warning btn-icon-shape rounded-circle">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="col-auto">
                    <h4>Large Circle (.btn-circle)</h4>
                    <button class="btn btn-warning btn-icon-shape btn-circle btn-animated-effect">
                        <i class="bi bi-cart-fill"></i>
                    </button>
                    <button class="btn btn-outline-warning btn-icon-shape btn-circle btn-animated-effect">
                        <i class="bi bi-cart"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Pill Buttons (.btn-pill)</h2>
            <div class="d-flex gap-3 flex-wrap">
                <button class="btn btn-warning btn-pill btn-animated-effect">Pill Solid</button>
                <button class="btn btn-outline-warning btn-pill btn-animated-effect">Pill Outline</button>
            </div>
        </div>
    </div>
</body>
</html>
