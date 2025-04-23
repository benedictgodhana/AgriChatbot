<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- External CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

    <!-- External JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.5/cdn.min.js" defer></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Farmer AI Chatbot</title>

    <style>
        /* Custom Font Definitions */
        @font-face {
            font-family: 'Futura LT';
            src: url('/fonts/futura-lt/FuturaLT-Book.ttf') format('woff2'),
                 url('/fonts/futura-lt/FuturaLT.ttf') format('woff'),
                 url('/fonts/futura-lt/FuturaLT-Condensed.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Enhanced Body and Global Styles */
        body {
            font-family: 'Futura LT', 'Poppins', sans-serif;
            background-color: #e6f3f3;
            color: #2c3e50;
            line-height: 1.6;
        }

        /* Custom Container Styles */
        .auth-container {
            background: linear-gradient(135deg, #ffffff 0%, #f0f9f9 100%);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 128, 128, 0.1);
            transition: all 0.3s ease;
        }

        .auth-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 128, 128, 0.15);
        }

        /* Logo and Header Styles */
        .app-logo {
            transition: transform 0.3s ease;
        }

        .app-logo:hover {
            transform: scale(1.1) rotate(5deg);
        }
    </style>

    <!-- Laravel Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-teal-50 to-teal-100">

        <div class="">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
