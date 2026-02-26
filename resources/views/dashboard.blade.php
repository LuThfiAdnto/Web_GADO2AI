<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GADO2AI - Dashboard Kapten</title>
    
    {{-- LOGO --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        html, body { height: 100%; width: 100%; overflow: hidden; font-family: 'Fredoka', sans-serif; margin: 0; padding: 0; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(251, 146, 60, 0.3); border-radius: 10px; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .animate-slide-up { animation: slideUp 0.3s ease-out forwards; }
    </style>
</head>
<body class="bg-yellow-50 text-gray-800 antialiased">

    {{-- Ambil status AI --}}
    @php
        $aiStatus = \App\Models\Setting::first()?->ai_active ?? true;
    @endphp

    <div class="flex flex-col h-full w-full overflow-hidden relative">
        {{-- NAVBAR --}}
        <nav class="flex-shrink-0 h-16 bg-[#FCD34D] border-b-4 border-yellow-500 flex items-center justify-between px-4 z-50 shadow-md">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="md:hidden p-2 bg-white rounded-full text-yellow-600 shadow-sm active:scale-95 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-white rounded-full border-2 border-white flex items-center justify-center text-pink-500 font-black text-lg shadow-sm">G</div>
                    <span class="font-black text-xl tracking-tight text-blue-700 hidden sm:block">GADO2<span class="text-pink-500">AI</span></span>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden md:flex bg-white px-3 py-1 rounded-full border-2 border-yellow-200 text-sm font-bold text-gray-700">
                    Hai, <span class="text-pink-600 ml-1">{{ Auth::user()->name }}! 👋</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-[#F87171] hover:bg-red-500 text-white text-xs md:text-sm font-bold px-4 py-2 rounded-full border-b-4 border-red-700 active:border-b-0 active:translate-y-1 transition shadow-sm">
                        Keluar 🚪
                    </button>
                </form>
            </div>
        </nav>

        <div class="flex-1 flex overflow-hidden relative">
            
            {{-- BACKGROUND --}}
            <div class="absolute inset-0 z-0 pointer-events-none">
                <div class="absolute top-10 left-10 w-40 h-40 bg-yellow-200 rounded-full blur-3xl opacity-40"></div>
                <div class="absolute bottom-10 right-10 w-40 h-40 bg-pink-200 rounded-full blur-3xl opacity-40"></div>
            </div>

            <div id="mobile-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden transition-opacity opacity-0 md:hidden"></div>

            {{-- SIDEBAR RIWAYAT --}}
            {{-- TAMBAHKAN 'pt-20 md:pt-0' AGAR TURUN DI HP TAPI NORMAL DI LAPTOP --}}
            <aside id="chat-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white/95 backdrop-blur-md border-r border-yellow-200 z-40 transform -translate-x-full transition-transform duration-300 md:relative md:translate-x-0 md:flex flex-col h-full shadow-2xl md:shadow-none pt-20 md:pt-0">
                <div class="p-4 flex-shrink-0">
                    <a href="{{ route('chat.index') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-gradient-to-r from-pink-500 to-orange-400 text-white font-bold rounded-2xl shadow-lg transform hover:scale-[1.02] active:scale-95 transition border-2 border-white">
                        <span>➕</span> Mulai Baru
                    </a>
                </div>

                <div class="flex-1 overflow-y-auto px-3 custom-scrollbar space-y-2 pb-4">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">RIWAYAT KAMU</p>
                    
                    @forelse($histories as $history)
                        <div class="group flex items-center justify-between px-3 py-3 rounded-xl transition-all border border-transparent {{ (isset($currentChat) && $currentChat->id == $history->id) ? 'bg-blue-50 border-blue-200 shadow-sm' : 'hover:bg-yellow-50 hover:shadow-sm' }}">
                            <a href="{{ route('chat.show', $history->id) }}" class="flex items-center gap-3 flex-1 min-w-0">
                                <span class="text-xl">📁</span>
                                <div class="overflow-hidden">
                                    <h4 class="text-sm font-bold text-gray-700 truncate w-32">{{ $history->title ?? 'Obrolan Baru' }}</h4>
                                    <p class="text-[10px] text-gray-400">{{ $history->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                            {{-- FORM HAPUS (Fix Method Delete) --}}
                            <form action="{{ route('chat.delete', $history->id) }}" method="POST" onsubmit="return confirm('Yakin hapus chat ini?');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="opacity-0 group-hover:opacity-100 text-red-400 hover:text-red-600 p-1 transition-opacity">🗑️</button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center p-4 text-gray-400 text-xs italic">Belum ada riwayat nih.</div>
                    @endforelse
                </div>
            </aside>

            {{-- MAIN CHAT AREA --}}
            <main class="flex-1 flex flex-col h-full relative z-10 bg-white/30 backdrop-blur-sm w-full">
                <div id="chat-box" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4 scroll-smooth custom-scrollbar w-full">
                    
                    @if(!isset($currentChat))
                        {{-- KONDISI 1: User baru login / Belum pilih chat --}}
                        <div class="flex flex-col items-center justify-center h-full text-center space-y-4 px-4 animate-slide-up">
                            <div class="w-24 h-24 bg-white rounded-3xl shadow-xl flex items-center justify-center text-5xl relative border-4 border-white">🤖</div>
                            <div>
                                <h2 class="text-2xl md:text-3xl font-black text-gray-800 drop-shadow-sm">Halo, Kapten <span class="text-pink-500">{{ Auth::user()->name }}</span>!</h2>
                                <p class="text-gray-500 font-bold mt-2 bg-white/80 inline-block px-4 py-2 rounded-full border border-white shadow-sm">Siap bertualang? Pilih riwayat atau mulai baru! 🚀</p>
                            </div>
                        </div>
                    @else
                        {{-- KONDISI 2: User sudah pilih chat --}}
                        @if($messages->count() == 0)
                             <div class="flex flex-col items-center justify-center h-3/4 text-center space-y-2 opacity-50">
                                <span class="text-4xl">📝</span>
                                <p class="text-sm font-bold text-gray-500">Belum ada pesan di sini, Kapten.<br>Yuk mulai mengetik!</p>
                             </div>
                        @else
                            @foreach($messages as $msg)
                                <div class="flex items-end gap-2 {{ $msg->role == 'user' ? 'flex-row-reverse' : '' }} mb-4 animate-slide-up">
                                    <div class="w-8 h-8 rounded-full {{ $msg->role == 'user' ? 'bg-green-500' : 'bg-pink-500' }} border-2 border-white flex-shrink-0 flex items-center justify-center text-white text-xs shadow-md">
                                        {{ $msg->role == 'user' ? '🧑‍🚀' : '🤖' }}
                                    </div>
                                    <div class="{{ $msg->role == 'user' ? 'bg-gradient-to-br from-green-400 to-emerald-500 text-white rounded-br-none' : 'bg-white text-gray-700 border border-gray-100 rounded-bl-none' }} p-3 px-4 rounded-2xl shadow-sm max-w-[85%] text-sm md:text-base font-medium leading-relaxed">
                                        {{ $msg->content }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                    @endif
                    <div id="scroll-anchor"></div>
                </div>

                {{-- INPUT AREA --}}
                <div class="flex-shrink-0 p-3 md:p-4 bg-white/90 backdrop-blur-lg border-t border-yellow-200 z-20 w-full">
                    <form id="chat-form" action="{{ route('chat.send') }}" method="POST" class="relative flex items-end gap-2 max-w-4xl mx-auto w-full">
                        @csrf
                        @if(isset($currentChat)) <input type="hidden" name="chat_id" value="{{ $currentChat->id }}"> @endif

                        <div class="relative flex-1 group">
                            <textarea 
                                name="message" 
                                id="user-input" 
                                rows="1" 
                                maxlength="300"
                                class="w-full border-4 border-blue-100 rounded-[24px] py-3 md:py-4 pl-5 pr-16 focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all font-bold text-gray-700 placeholder-gray-400 bg-white shadow-inner text-sm md:text-base disabled:bg-gray-100 disabled:cursor-not-allowed resize-none overflow-hidden" 
                                placeholder="{{ $aiStatus ? 'Ketik pertanyaanmu di sini...' : '⛔ AI sedang Istirahat' }}" 
                                required 
                                {{ $aiStatus ? '' : 'disabled' }}
                                style="min-height: 56px; max-height: 200px;"
                            ></textarea>

                            <div id="char-counter" class="hidden group-focus-within:block absolute right-4 bottom-4 text-xs font-bold text-pink-300 bg-white px-1">
                                0/300
                            </div>
                        </div>

                        <button type="submit" id="send-btn" {{ $aiStatus ? '' : 'disabled' }} class="flex-shrink-0 w-12 h-12 md:w-14 md:h-14 mb-1 bg-gradient-to-r from-pink-500 to-orange-500 rounded-full text-white flex items-center justify-center shadow-lg hover:scale-105 active:scale-95 transition-all disabled:opacity-50 disabled:scale-100 border-4 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7 transform rotate-90 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Sidebar
            window.toggleSidebar = function() {
                const sidebar = document.getElementById('chat-sidebar');
                const overlay = document.getElementById('mobile-overlay');
                const isOpen = sidebar.classList.contains('translate-x-0'); 
                if (isOpen) {
                    sidebar.classList.remove('translate-x-0'); sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                } else {
                    sidebar.classList.remove('-translate-x-full'); sidebar.classList.add('translate-x-0');
                    overlay.classList.remove('hidden'); setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                }
            };

            const chatBox = document.getElementById('chat-box');
            const chatForm = document.getElementById('chat-form');
            const input = document.getElementById('user-input');
            const sendBtn = document.getElementById('send-btn');
            const counter = document.getElementById('char-counter');

            // --- [FITUR BARU] TANGKAP PESAN DARI WELCOME PAGE ---
            // Cek apakah ada parameter ?start_message=... di URL
            const urlParams = new URLSearchParams(window.location.search);
            const startMessage = urlParams.get('start_message');

            if (startMessage && input && chatForm) {
                // 1. Masukkan teks ke dalam textarea
                input.value = startMessage;
                
                // 2. Sesuaikan tinggi textarea
                input.style.height = 'auto'; 
                input.style.height = input.scrollHeight + 'px';
                
                // 3. Bersihkan URL (hapus parameternya biar bersih)
                window.history.replaceState({}, document.title, window.location.pathname);

                // 4. Otomatis Kirim (Pake jeda dikit biar user 'ngeh' / UI siap)
                setTimeout(() => {
                    sendBtn.disabled = false;
                    // Trigger submit secara manual
                    chatForm.requestSubmit();
                }, 500); 
            }
            // ----------------------------------------------------

            // --- AUTO RESIZE TEXTAREA ---
            if (input) {
                const autoResize = () => {
                    input.style.height = 'auto'; 
                    input.style.height = input.scrollHeight + 'px'; 
                };

                input.addEventListener('input', function() {
                    autoResize();
                    if(counter) counter.innerText = this.value.length + '/300';
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault(); 
                        if (!sendBtn.disabled) chatForm.requestSubmit(); 
                    }
                });
            }

            // --- LOGIKA SUBMIT ---
            if(chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault(); 
                    const message = input.value.trim();
                    if(!message) return;

                    addBubble(message, 'user');
                    
                    input.value = '';
                    input.style.height = 'auto'; 
                    input.style.height = '56px'; 
                    
                    sendBtn.disabled = true;
                    scrollToBottom();
                    const loadingId = showLoading();

                    const chatIdInput = document.querySelector('input[name="chat_id"]');
                    const chatId = chatIdInput ? chatIdInput.value : null;

                    fetch("{{ route('chat.send') }}", {
                        method: "POST",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" },
                        body: JSON.stringify({ message: message, chat_id: chatId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById(loadingId)?.remove();
                        if(data.reply) addBubble(data.reply, 'ai');
                        if(data.chat_id && !chatIdInput) {
                            const newHidden = document.createElement('input');
                            newHidden.type = 'hidden'; newHidden.name = 'chat_id'; newHidden.value = data.chat_id;
                            chatForm.appendChild(newHidden);
                            window.history.pushState({}, '', '/chat/' + data.chat_id);
                        }
                    })
                    .catch(err => {
                        document.getElementById(loadingId)?.remove();
                        addBubble("Sinyal putus kapten! 🔌", 'ai');
                    })
                    .finally(() => { 
                        sendBtn.disabled = false; 
                        input.focus(); 
                        scrollToBottom(); 
                    });
                });
            }
            
            function scrollToBottom() { if(chatBox) chatBox.scrollTop = chatBox.scrollHeight; }
            
            function addBubble(text, role) {
                const formattedText = text.replace(/\n/g, "<br>");
                const div = document.createElement('div');
                div.className = `flex items-end gap-2 ${role === 'user' ? 'flex-row-reverse' : ''} mb-4 animate-slide-up`;
                const bg = role === 'user' ? 'bg-gradient-to-br from-green-400 to-emerald-500 text-white rounded-br-none' : 'bg-white text-gray-700 border border-gray-100 rounded-bl-none';
                div.innerHTML = `<div class="w-8 h-8 rounded-full ${role === 'user' ? 'bg-green-500' : 'bg-pink-500'} border-2 border-white flex-shrink-0 flex items-center justify-center text-white text-xs shadow-md">${role === 'user' ? '🧑‍🚀' : '🤖'}</div><div class="${bg} p-3 px-4 rounded-2xl shadow-sm max-w-[85%] text-sm md:text-base font-medium leading-relaxed break-words">${formattedText}</div>`;
                document.getElementById('scroll-anchor') ? chatBox.insertBefore(div, document.getElementById('scroll-anchor')) : chatBox.appendChild(div);
                scrollToBottom();
            }
            
            function showLoading() {
                    const id = 'loading-' + Date.now();
                    const div = document.createElement('div');
                    div.id = id;
                    div.className = "flex items-end gap-2 mb-4 animate-pulse";
                    div.innerHTML = `<div class="w-8 h-8 rounded-full bg-pink-500 border-2 border-white flex flex-center items-center justify-center text-white text-xs">🤖</div><div class="bg-white p-3 rounded-2xl shadow-sm text-gray-400 text-xs">Mengetik...</div>`;
                    document.getElementById('scroll-anchor') ? chatBox.insertBefore(div, document.getElementById('scroll-anchor')) : chatBox.appendChild(div);
                    scrollToBottom();
                    return id;
            }

        });
    </script>
</body>
</html>