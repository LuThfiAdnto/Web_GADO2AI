<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Masuk Yuk! - GADO2AI</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Fredoka', sans-serif;
                background-color: #FDF2F8; /* Pink Muda */
                background-image: radial-gradient(#FBCFE8 2px, transparent 2px), radial-gradient(#FBCFE8 2px, #FDF2F8 2px);
                background-size: 32px 32px;
                background-position: 0 0, 16px 16px;
            }
            .card-toy {
                background: #FFFFFF;
                border: 6px solid #FDBA74; /* Sedikit lebih tipis di HP */
                border-radius: 1.5rem;
                box-shadow: 6px 6px 0px #FED7AA; /* Shadow lebih kecil di HP */
            }
            
            /* Tampilan Desktop (Layar > 640px) */
            @media (min-width: 640px) {
                .card-toy {
                    border: 8px solid #FDBA74;
                    border-radius: 2rem;
                    box-shadow: 10px 10px 0px #FED7AA;
                }
            }
        </style>
    </head>
    <body class="text-gray-800 antialiased overflow-x-hidden"> <div class="min-h-screen flex flex-col justify-center items-center py-6 sm:py-0 px-4 relative overflow-hidden">
            
            <div class="absolute top-4 left-4 sm:top-10 sm:left-10 text-4xl sm:text-6xl animate-bounce z-0 opacity-60 sm:opacity-100">🧸</div>
            <div class="absolute bottom-4 right-4 sm:bottom-10 sm:right-10 text-4xl sm:text-6xl animate-spin-slow z-0 opacity-60 sm:opacity-100">🎡</div>

            <div class="relative z-10 mb-6 text-center">
                <a href="/" class="flex flex-col items-center gap-2 justify-center hover:scale-110 transition duration-300">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-yellow-400 border-4 border-yellow-200 rounded-full flex items-center justify-center font-black text-pink-600 text-2xl sm:text-4xl shadow-lg transform -rotate-6">
                        G
                    </div>
                    <span class="text-3xl sm:text-4xl font-black tracking-tight text-blue-600 mt-2 drop-shadow-sm">
                        GADO2<span class="text-pink-500">AI</span> Kids
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 sm:px-8 sm:py-10 card-toy relative z-10 bg-white">
                <div class="text-gray-700">
                    {{ $slot }}
                </div>
            </div>
            
            <div class="mt-8 text-blue-600 font-bold text-base sm:text-lg relative z-10 text-center">
               🎈 Area Bermain GADO2AI
            </div>
        </div>
    </body>
</html>