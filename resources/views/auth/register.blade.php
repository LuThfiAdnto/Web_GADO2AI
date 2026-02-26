<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4 md:space-y-6">
        @csrf

        <div class="text-center mb-4 md:mb-6">
            <h2 class="text-2xl md:text-3xl font-black text-blue-600 drop-shadow-sm">Daftar Akun Baru 🚀</h2>
            <p class="text-gray-500 text-sm md:text-base font-bold">Gabung dan mulai petualangan!</p>
        </div>

        <div>
            <label for="name" class="block font-bold text-sm text-blue-600 mb-1 pl-2">Nama Lengkap</label>
            <input id="name" class="w-full border-4 border-blue-200 rounded-full px-5 py-3 font-bold text-gray-700 focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all bg-blue-50 focus:bg-white text-sm md:text-base" 
                   type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                   placeholder="Siapa namamu?">
            <x-input-error :messages="$errors->get('name')" class="mt-1 pl-2 text-red-500 font-bold text-xs" />
        </div>

        <div>
            <label for="email" class="block font-bold text-sm text-blue-600 mb-1 pl-2">Email</label>
            <input id="email" class="w-full border-4 border-blue-200 rounded-full px-5 py-3 font-bold text-gray-700 focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all bg-blue-50 focus:bg-white text-sm md:text-base" 
                   type="email" name="email" :value="old('email')" required autocomplete="username" 
                   placeholder="email@contoh.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 pl-2 text-red-500 font-bold text-xs" />
        </div>

        <div class="relative">
            <label for="password" class="block font-bold text-sm text-orange-500 mb-1 pl-2">Kata Sandi</label>
            <div class="relative">
                <input id="password" class="w-full border-4 border-orange-200 rounded-full px-5 py-3 pr-12 font-bold text-gray-700 focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all bg-orange-50 focus:bg-white text-sm md:text-base"
                       type="password" name="password" required autocomplete="new-password" 
                       placeholder="Rahasia! Jangan bilang-bilang ya!">
                
                <button type="button" onclick="toggleRegisterPassword('password', 'eye-open-1', 'eye-closed-1')" 
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-pink-600 focus:outline-none transition-colors"
                        style="-webkit-tap-highlight-color: transparent;"> <svg id="eye-open-1" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-closed-1" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 pl-2 text-red-500 font-bold text-xs" />
        </div>

        <div class="relative">
            <label for="password_confirmation" class="block font-bold text-sm text-orange-500 mb-1 pl-2">Ulangi Kata Sandi</label>
            <div class="relative">
                <input id="password_confirmation" class="w-full border-4 border-orange-200 rounded-full px-5 py-3 pr-12 font-bold text-gray-700 focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all bg-orange-50 focus:bg-white text-sm md:text-base"
                       type="password" name="password_confirmation" required autocomplete="new-password" 
                       placeholder="Ketik ulang ya!">
                
                <button type="button" onclick="toggleRegisterPassword('password_confirmation', 'eye-open-2', 'eye-closed-2')" 
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-pink-600 focus:outline-none transition-colors"
                        style="-webkit-tap-highlight-color: transparent;">
                    <svg id="eye-open-2" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-closed-2" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 pl-2 text-red-500 font-bold text-xs" />
        </div>

        <div class="mt-6 space-y-4">
            <button type="submit" class="w-full py-3 md:py-4 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-400 hover:to-purple-500 text-white font-black text-lg md:text-xl rounded-full shadow-[0_4px_0_rgb(190,24,93)] active:shadow-none active:translate-y-1 transition-all transform hover:scale-[1.02]">
                DAFTAR SEKARANG 🚀
            </button>

            <div class="text-center">
                <p class="text-sm font-bold text-gray-500">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="text-blue-600 font-black hover:text-pink-500 hover:underline transition text-sm md:text-base">
                    Masuk di sini aja! ✨
                </a>
            </div>
        </div>
    </form>

    <script>
        function toggleRegisterPassword(inputId, openIconId, closedIconId) {
            const input = document.getElementById(inputId);
            const openIcon = document.getElementById(openIconId);
            const closedIcon = document.getElementById(closedIconId);

            if (input.type === 'password') {
                input.type = 'text';
                openIcon.classList.remove('hidden');
                closedIcon.classList.add('hidden');
            } else {
                input.type = 'password';
                openIcon.classList.add('hidden');
                closedIcon.classList.remove('hidden');
            }
        }
    </script>
</x-guest-layout>