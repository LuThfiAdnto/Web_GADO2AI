<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
        @csrf

        <div class="text-center mb-2 md:mb-6">
            <h2 class="text-2xl md:text-3xl font-black text-pink-500 drop-shadow-sm">Selamat Datang! 👋</h2>
            <p class="text-gray-500 text-sm md:text-base font-bold">Masukkan kunci rahasiamu ya!</p>
        </div>

        <div>
            <label for="email" class="block font-bold text-sm text-blue-600 mb-1 pl-2">Email Kamu</label>
            <input id="email" class="w-full border-4 border-blue-200 rounded-full px-5 py-3 font-bold text-gray-700 focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all bg-blue-50 focus:bg-white text-sm md:text-base" 
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                   placeholder="contoh: aku@hebat.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 pl-2 text-red-500 font-bold text-xs" />
        </div>

        <div class="relative">
            <label for="password" class="block font-bold text-sm text-orange-500 mb-1 pl-2">Kata Sandi</label>
            
            <div class="relative w-full">
                <input id="password" class="w-full border-4 border-orange-200 rounded-full px-5 py-3 pr-12 font-bold text-gray-700 focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all bg-orange-50 focus:bg-white text-sm md:text-base" 
                       type="password" name="password" required autocomplete="current-password"
                       placeholder="Rahasia banget!">
                
                <button type="button" onclick="togglePassword()" 
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-pink-600 focus:outline-none transition-colors"
                        style="-webkit-tap-highlight-color: transparent;">
                    
                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    
                    <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-1 pl-2 text-red-500 font-bold text-xs" />
        </div>

        <div class="flex items-center justify-between mt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-gray-300 text-pink-500 shadow-sm focus:ring-pink-500 w-5 h-5" name="remember">
                <span class="ml-2 text-sm font-bold text-gray-600">Ingat Aku ya!</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm font-bold text-blue-500 hover:text-pink-500 transition" href="{{ route('password.request') }}">
                    Lupa Sandi?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button class="w-full py-3 md:py-4 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-400 hover:to-purple-500 text-white font-black text-lg md:text-xl rounded-full shadow-[0_4px_0_rgb(190,24,93)] active:shadow-none active:translate-y-1 transition-all transform hover:scale-[1.02]">
                MASUK SEKARANG! 🚀
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-sm font-bold text-gray-500 mb-1">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="text-blue-600 font-black hover:text-pink-500 hover:underline transition text-sm md:text-base">
                Daftar dulu yuk di sini! ✨
            </a>
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                // Ubah jadi text (terlihat)
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                // Ubah jadi password (bintang-bintang)
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    </script>
</x-guest-layout>