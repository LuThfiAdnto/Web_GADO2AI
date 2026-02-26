<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GADO2AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background: #E0F2FE;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.8) 0%, transparent 20%),
                radial-gradient(circle at 80% 50%, rgba(255, 255, 255, 0.8) 0%, transparent 20%);
            background-size: 300px 300px;
            animation: clouds MoveClouds 20s linear infinite;
        }
        @keyframes MoveClouds { from {background-position: 0 0;} to {background-position: 300px 0;} }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-bottom: 4px solid #FDBA74; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .text-outline { text-shadow: 3px 3px 0px #F472B6, -1px -1px 0px #F472B6, 1px -1px 0px #F472B6, -1px 1px 0px #F472B6, 1px 1px 0px #F472B6; }
        .btn-candy { background: linear-gradient(to bottom, #F472B6, #EC4899); border: 4px solid #FBCFE8; box-shadow: 0 4px 0 #BE185D; transition: all 0.1s; }
        .btn-candy:active { box-shadow: 0 2px 0 #BE185D; transform: translateY(4px); }
        .floating-img { animation: float 4s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(2deg); } }
    </style>
</head>
<body class="text-gray-800 antialiased overflow-x-hidden selection:bg-yellow-300 selection:text-pink-600">

    <nav class="fixed w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-2 md:gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-400 rounded-full border-4 border-yellow-200 flex items-center justify-center shadow-lg transform -rotate-6">
                        <span class="text-xl md:text-2xl font-black text-pink-600">G</span>
                    </div>
                    <span class="text-xl md:text-2xl font-black tracking-wider text-blue-600 drop-shadow-sm">
                        GADO2<span class="text-pink-500">AI</span> 🎈
                    </span>
                </div>
                <div class="flex items-center gap-2 md:gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm md:text-lg font-bold text-blue-600 hover:text-pink-500 transition bg-white px-3 py-2 md:px-4 md:py-2 rounded-full border-2 border-blue-200">
                                Dashboard 🚀
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm md:text-lg font-bold text-blue-600 hover:text-pink-500 transition bg-white px-3 py-1.5 md:px-4 md:py-2 rounded-full border-2 border-blue-200 whitespace-nowrap">
                                Masuk 🔐
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-1.5 md:px-6 md:py-3 btn-candy text-white font-black rounded-full text-sm md:text-lg whitespace-nowrap">
                                    Daftar Yuk! ✨
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative min-h-screen flex items-center justify-center pt-24 pb-12 md:pt-20">
        {{-- DEKORASI --}}
        <div class="hidden md:block absolute top-32 left-10 text-6xl floating-img" style="animation-delay: 0.5s">🦄</div>
        <div class="hidden md:block absolute bottom-20 right-10 text-6xl floating-img" style="animation-delay: 1s">🚀</div>
        <div class="md:hidden absolute top-24 right-5 text-4xl floating-img opacity-80">🦄</div>
        <div class="md:hidden absolute bottom-10 left-5 text-4xl floating-img opacity-80">🚀</div>

        <div class="absolute top-40 right-32 w-20 h-20 md:w-32 md:h-32 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
        <div class="absolute bottom-40 left-32 w-24 h-24 md:w-40 md:h-40 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 2s"></div>

        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto w-full">
            <div class="inline-block mb-4 px-4 py-1.5 md:px-6 md:py-2 rounded-full bg-yellow-300 border-4 border-yellow-100 text-yellow-700 text-sm md:text-lg font-bold tracking-wide uppercase shadow-sm rotate-2">
                ✨ Tempat Belajar Paling Seru!
            </div>
            
            <h1 class="text-4xl md:text-7xl font-black mb-6 leading-tight text-white text-outline drop-shadow-xl">
                SELAMAT DATANG DI <br>
                DUNIA AI ANAK-ANAK
            </h1>
            
            <p class="text-base md:text-2xl text-blue-800 mb-8 md:mb-10 max-w-2xl mx-auto leading-relaxed font-bold bg-white/60 p-4 md:p-6 rounded-3xl backdrop-blur-sm border-4 border-blue-200 shadow-md">
                Ayo belajar, bermain, dan menciptakan hal ajaib dengan komputer pintar! 
                Gampang banget, serasa main game! 🎮
            </p>
            
            {{-- FORM PINTAR --}}
            <div class="w-full max-w-xl mx-auto mt-6 relative z-20">
                <form action="{{ Auth::check() ? route('dashboard') : route('login') }}" method="GET" class="relative group transform transition-all hover:scale-[1.02]">
                    
                    <input 
                        type="text" 
                        name="start_message" 
                        placeholder="Apa yang ingin kamu pelajari hari ini?" 
                        class="w-full h-14 md:h-16 pl-6 pr-20 rounded-full border-4 border-yellow-300 bg-white text-gray-700 font-bold text-lg md:text-xl shadow-xl focus:outline-none focus:border-pink-400 focus:ring-4 focus:ring-pink-200 placeholder-gray-400 transition-all"
                        autocomplete="off"
                        required
                    >
                    
                    <button 
                        type="submit" 
                        class="absolute right-2 top-2 bottom-2 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full flex items-center justify-center text-white shadow-md hover:scale-110 active:scale-95 transition-all border-2 border-white"
                        title="Mulai Petualangan!"
                    >
                        <span class="text-xl md:text-2xl mb-0.5 ml-0.5">➤</span>
                    </button>
                </form>
                
                <p class="text-blue-700 font-bold mt-3 text-xs md:text-sm opacity-90 tracking-wide animate-pulse">
                    🚀 Ketik pesanmu di atas Kids!
                </p>
            </div>
        </div>
    </div>

    {{-- FOOTER AREA --}}
    <div class="bg-white border-t-8 border-yellow-300 py-10 md:py-12 relative overflow-hidden">
         <svg class="absolute top-[-1px] left-0 w-full text-yellow-300 h-8 md:h-12" fill="currentColor" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center relative z-10 mt-6 md:mt-8">
            <div class="bg-blue-100 p-6 rounded-3xl border-4 border-blue-300 transform hover:scale-105 transition shadow-sm">
                <div class="text-5xl mb-2">🧠</div>
                <div class="text-3xl md:text-4xl font-black text-blue-600 mb-1">Pintar</div>
                <div class="text-base md:text-lg text-blue-500 font-bold">Teknologi Canggih</div>
            </div>
             <div class="bg-pink-100 p-6 rounded-3xl border-4 border-pink-300 transform hover:scale-105 transition shadow-sm">
                <div class="text-5xl mb-2">🎨</div>
                <div class="text-3xl md:text-4xl font-black text-pink-600 mb-1">Kreatif</div>
                <div class="text-base md:text-lg text-pink-500 font-bold">Bikin Karyamu</div>
            </div>
             <div class="bg-yellow-100 p-6 rounded-3xl border-4 border-yellow-300 transform hover:scale-105 transition shadow-sm">
                <div class="text-5xl mb-2">🛡️</div>
                <div class="text-3xl md:text-4xl font-black text-yellow-600 mb-1">Aman</div>
                <div class="text-base md:text-lg text-yellow-600 font-bold">Untuk Anak-anak</div>
            </div>
             <div class="bg-green-100 p-6 rounded-3xl border-4 border-green-300 transform hover:scale-105 transition shadow-sm">
                <div class="text-5xl mb-2">👨‍👩‍👧‍👦</div>
                <div class="text-3xl md:text-4xl font-black text-green-600 mb-1">Seru</div>
                <div class="text-base md:text-lg text-green-600 font-bold">Banyak Teman</div>
            </div>
        </div>
    </div>

    <footer class="py-8 text-center text-blue-600 font-bold text-lg bg-yellow-300 border-t-4 border-yellow-500">
        <p class="px-4">Dibuat dengan 💖 dan 🍭 untuk Masa Depan Ceria!</p>
        <p class="text-sm mt-2">&copy; {{ date('Y') }} GADO2AI Kids.</p>
    </footer>
</body>
</html>