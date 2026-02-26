<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Markas Kapten Admin | GADO2AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700;900&display=swap" rel="stylesheet">
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
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 3px solid #FDBA74;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .text-outline {
            text-shadow: 2px 2px 0px #F472B6, -1px -1px 0px #F472B6, 1px -1px 0px #F472B6, -1px 1px 0px #F472B6, 1px 1px 0px #F472B6;
        }
        .btn-switch-on {
            background: linear-gradient(to bottom, #4ADE80, #22C55E);
            border: 3px solid #BBF7D0;
            box-shadow: 0 3px 0 #15803D;
        }
        .btn-switch-off {
            background: linear-gradient(to bottom, #EF4444, #DC2626);
            border: 3px solid #FECACA;
            box-shadow: 0 3px 0 #991B1B;
        }
        .btn-switch-on:active, .btn-switch-off:active { transform: translateY(2px); box-shadow: 0 1px 0; }
        
        .floating-img { animation: float 4s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-10px) rotate(2deg); } }

        @keyframes bounceIn {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-bounce-in { animation: bounceIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    </style>
</head>
<body class="text-gray-800 antialiased overflow-x-hidden selection:bg-yellow-300 selection:text-pink-600 text-sm md:text-base">

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-50 glass-nav h-16 md:h-24 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full">
                <div class="flex items-center gap-2 md:gap-3">
                    <div class="w-9 h-9 md:w-14 md:h-14 bg-yellow-400 rounded-full border-2 md:border-4 border-yellow-200 flex items-center justify-center shadow-lg transform -rotate-6 shrink-0">
                        <span class="text-lg md:text-3xl font-black text-pink-600">G</span>
                    </div>
                    <span class="text-lg md:text-3xl font-black tracking-wider text-blue-600 drop-shadow-sm flex items-center">
                        GADO2<span class="text-pink-500">AI</span> 
                        <span class="hidden sm:inline-block text-[10px] md:text-sm ml-2 px-2 py-0.5 md:px-3 md:py-1 bg-white rounded-full text-orange-500 border border-orange-200 align-middle">ADMIN</span>
                    </span>
                </div>
                <div class="flex items-center gap-2 md:gap-4">
                    <div class="hidden md:block bg-white px-4 py-2 rounded-full border-2 border-yellow-200 text-sm font-bold text-gray-700 shadow-sm">
                        Kapten <span class="text-pink-600">{{ auth()->user()->name }} 🎖️</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs md:text-base font-bold text-red-500 hover:text-red-700 transition bg-white px-3 py-1.5 md:px-5 md:py-2.5 rounded-full border-b-2 md:border-b-4 border-red-200 active:border-b-0 active:translate-y-0.5">
                            Keluar 🚪
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative min-h-screen flex flex-col pt-20 md:pt-32 pb-8 md:pb-12 px-3 md:px-8">
        
        {{-- ALERTS --}}
        @if(session('success'))
        <div id="alert-success" class="fixed top-20 inset-x-0 z-50 flex justify-center pointer-events-none">
            <div class="animate-bounce bg-yellow-300 border-2 md:border-4 border-yellow-500 text-yellow-900 px-4 py-2 md:px-8 md:py-4 rounded-xl md:rounded-3xl shadow-xl font-bold text-xs md:text-lg inline-flex items-center gap-2 pointer-events-auto mx-4">
                <span>🎉</span> {{ session('success') }}
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div id="alert-error" class="fixed top-20 inset-x-0 z-50 flex justify-center pointer-events-none">
            <div class="animate-bounce bg-red-300 border-2 md:border-4 border-red-500 text-red-900 px-4 py-2 md:px-8 md:py-4 rounded-xl md:rounded-3xl shadow-xl font-bold text-xs md:text-lg inline-flex items-center gap-2 pointer-events-auto mx-4">
                <span>⚠️</span> {{ session('error') }}
            </div>
        </div>
        @endif

        {{-- Dekorasi --}}
        <div class="absolute top-32 left-10 text-6xl floating-img hidden lg:block opacity-90" style="animation-delay: 0.5s">🦄</div>
        <div class="absolute bottom-20 right-10 text-6xl floating-img hidden lg:block opacity-90" style="animation-delay: 1s">🚀</div>

        <div class="relative z-10 w-full max-w-7xl mx-auto flex-1 flex flex-col">
            
            <div class="text-center mb-6 md:mb-10">
                <h1 class="text-2xl md:text-6xl font-black mb-1 md:mb-3 leading-tight text-white text-outline">
                    MARKAS BESAR 🏰
                </h1>
                <p class="text-xs md:text-base text-gray-600 font-bold bg-white/60 inline-block px-3 py-1 md:px-6 md:py-2 rounded-full border-2 md:border-4 border-white shadow-sm">
                    Panel Kontrol Pasukan & AI
                </p>
            </div>

            {{-- GRID LAYOUT: DIUBAH UNTUK MUAT 3 ITEM --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 mb-6 md:mb-8">
                
                {{-- 1. STATUS ROBOT (KIRI) --}}
                <div class="md:col-span-1 bg-white/90 backdrop-blur-md p-5 md:p-8 rounded-2xl md:rounded-[2rem] border-4 md:border-8 border-white shadow-xl flex flex-col items-center justify-center text-center h-full min-h-[250px]">
                    <h2 class="text-sm md:text-lg font-black text-blue-500 mb-3 md:mb-6 uppercase tracking-widest">Status Robot</h2>
                    
                    <div class="text-6xl md:text-8xl mb-3 md:mb-6 transform transition hover:scale-110 duration-300 cursor-pointer">
                        {{ ($aiStatus->ai_active ?? true) ? '🤖' : '💤' }}
                    </div>
                    
                    <div class="mb-4 md:mb-8">
                        <span class="{{ ($aiStatus->ai_active ?? true) ? 'text-green-500' : 'text-red-500' }} text-xl md:text-3xl uppercase font-black tracking-wide block">
                            {{ ($aiStatus->ai_active ?? true) ? 'AKTIF ✅' : 'MATI ⛔' }}
                        </span>
                    </div>

                    <form action="{{ route('admin.ai.toggle') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full px-4 py-3 md:px-8 md:py-4 text-white font-black text-sm md:text-lg rounded-xl md:rounded-2xl transition transform active:scale-95 shadow-md md:shadow-xl {{ ($aiStatus->ai_active ?? true) ? 'btn-switch-off' : 'btn-switch-on' }}">
                            {{ ($aiStatus->ai_active ?? true) ? 'MATIKAN' : 'NYALAKAN' }}
                        </button>
                    </form>
                </div>

                {{-- 2. EDITOR PERSONA (KANAN / TENGAH - BARU) --}}
                <div class="md:col-span-2 bg-white/90 backdrop-blur-md p-5 md:p-8 rounded-2xl md:rounded-[2rem] border-4 md:border-8 border-yellow-200 shadow-xl flex flex-col relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl pointer-events-none">🧠</div>
                    
                    <div class="mb-4">
                        <h2 class="text-sm md:text-lg font-black text-yellow-600 uppercase tracking-widest flex items-center gap-2">
                            <span>✏️</span> Otak & Kepribadian
                        </h2>
                        <p class="text-xs text-gray-500 font-bold mt-1">Atur cara bicara dan aturan robot di sini.</p>
                    </div>

                    <form action="{{ route('admin.prompt.update') }}" method="POST" class="flex-1 flex flex-col h-full">
                        @csrf
                        <textarea name="system_prompt" 
                            class="flex-1 w-full rounded-xl border-2 md:border-4 border-yellow-100 p-4 text-xs md:text-base font-bold text-gray-700 focus:border-yellow-400 outline-none resize-none bg-yellow-50/50 custom-scrollbar mb-4 min-h-[150px] shadow-inner" 
                            placeholder="Contoh: Kamu adalah Bajak Laut yang suka matematika..."
                            required>{{ $aiStatus->system_prompt ?? "PERAN: Kamu adalah 'Gado2ai', robot sahabat anak-anak SD yang ceria, lucu, dan pintar.\n\nATURAN WAJIB:\n1. Jawablah dengan bahasa Indonesia yang santai dan seru.\n2. Panggil pengguna dengan 'Kapten'.\n3. Jangan bicara teknis (coding, laravel, dll).\n4. Jawaban harus PENDEK (max 3-4 kalimat)." }}</textarea>
                        
                        <div class="text-right">
                            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white font-black px-6 py-3 rounded-xl shadow-md border-b-4 border-yellow-600 active:border-b-0 active:translate-y-1 transition text-xs md:text-sm uppercase tracking-wide">
                                Simpan Perubahan 💾
                            </button>
                        </div>
                    </form>
                </div>

                {{-- 3. TABEL PASUKAN (BAWAH - FULL WIDTH) --}}
                <div class="md:col-span-3 bg-white/90 backdrop-blur-md p-4 md:p-8 rounded-2xl md:rounded-[2rem] border-4 md:border-8 border-blue-200 shadow-xl flex flex-col h-full min-h-[300px] md:min-h-[400px]">
                    
                    <div class="flex items-center justify-between mb-4 md:mb-6">
                        <div class="flex items-center gap-2 md:gap-4">
                            <h2 class="text-lg md:text-3xl font-black text-pink-500 uppercase tracking-wide text-outline">
                                🧑‍🚀 Pasukan
                            </h2>
                            <span class="bg-blue-100 text-blue-600 text-[10px] md:text-sm font-bold px-2 py-1 md:px-4 md:py-1.5 rounded-lg md:rounded-xl border border-blue-200 shadow-sm">
                                {{ collect($users ?? [])->count() }} Orang
                            </span>
                        </div>
                        <button onclick="openModal('add-modal')" class="bg-green-500 hover:bg-green-600 text-white font-black px-3 py-2 md:px-6 md:py-3 rounded-xl md:rounded-full border-b-4 border-green-700 hover:scale-105 active:border-b-0 active:translate-y-1 transition text-xs md:text-sm shadow-md flex items-center gap-1">
                            <span class="text-sm md:text-xl">➕</span> Tambah
                        </button>
                    </div>

                    <div class="overflow-x-auto rounded-xl md:rounded-3xl border-2 md:border-4 border-blue-100 flex-1 custom-scrollbar">
                        <table class="w-full text-left border-collapse bg-white whitespace-nowrap">
                            <thead class="sticky top-0 bg-blue-50 z-10">
                                <tr class="text-blue-600 border-b-2 md:border-b-4 border-blue-200 text-xs md:text-base uppercase">
                                    <th class="p-3 md:p-4 font-black text-center w-10">No</th>
                                    <th class="p-3 md:p-4 font-black">Nama</th>
                                    <th class="p-3 md:p-4 font-black">Email</th>
                                    <th class="p-3 md:p-4 font-black text-center">Pangkat</th>
                                    <th class="p-3 md:p-4 font-black text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-xs md:text-base font-bold">
                                @foreach($users as $index => $user)
                                <tr class="hover:bg-yellow-50 transition border-b border-gray-100 last:border-0 group">
                                    <td class="p-3 md:p-4 text-center">
                                        <div class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-yellow-200 inline-flex items-center justify-center text-yellow-800 text-[10px] md:text-sm shadow-sm">{{ $index + 1 }}</div>
                                    </td>
                                    <td class="p-3 md:p-4">
                                        <div class="flex items-center gap-2 md:gap-3">
                                            <span class="text-lg md:text-2xl filter grayscale group-hover:grayscale-0 transition">{{ $user->role == 'admin' ? '👑' : '🚀' }}</span>
                                            <span class="truncate max-w-[90px] md:max-w-[200px]">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3 md:p-4 text-gray-500 font-medium truncate max-w-[100px] md:max-w-[180px]">{{ $user->email }}</td>
                                    <td class="p-3 md:p-4 text-center">
                                        <span class="px-2 py-1 md:px-4 md:py-1.5 rounded-lg md:rounded-xl text-[9px] md:text-xs font-black border shadow-sm uppercase tracking-wide {{ $user->role === 'admin' ? 'bg-pink-100 text-pink-600 border-pink-200' : 'bg-blue-100 text-blue-600 border-blue-200' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="p-3 md:p-4 text-center">
                                        <div class="flex justify-center gap-2 opacity-100 md:opacity-80 md:group-hover:opacity-100 transition">
                                            <button onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" 
                                                class="w-7 h-7 md:w-10 md:h-10 bg-yellow-400 text-white rounded-lg md:rounded-xl hover:bg-yellow-500 flex items-center justify-center border-b-2 md:border-b-4 border-yellow-600 active:border-b-0 active:translate-y-1 transition shadow-sm" title="Edit">
                                                ✏️
                                            </button>
                                            @if($user->id !== auth()->id())
                                            <button onclick="openDeleteModal('{{ $user->id }}', '{{ $user->name }}')" 
                                                class="w-7 h-7 md:w-10 md:h-10 bg-red-500 text-white rounded-lg md:rounded-xl hover:bg-red-600 flex items-center justify-center border-b-2 md:border-b-4 border-red-700 active:border-b-0 active:translate-y-1 transition shadow-sm" title="Hapus">
                                                🗑️
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center mt-2 md:mt-6 pb-6 md:pb-10">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 md:gap-3 bg-white px-5 py-2 md:px-8 md:py-4 rounded-full text-blue-500 hover:text-blue-700 font-black text-xs md:text-base uppercase tracking-widest border-2 md:border-4 border-blue-200 shadow-md md:shadow-lg transition hover:-translate-y-1">
                    <span class="text-base md:text-xl">🔙</span> Kembali ke Chat
                </a>
            </div>

        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div id="add-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('add-modal')"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[95%] md:w-[90%] max-w-lg p-3 md:p-4">
            <div class="bg-white rounded-2xl md:rounded-[2rem] border-4 md:border-8 border-green-200 shadow-2xl p-5 md:p-8 relative animate-bounce-in">
                <button onclick="closeModal('add-modal')" class="absolute top-3 right-4 md:top-4 md:right-5 text-gray-300 hover:text-red-500 font-bold text-xl md:text-3xl">✕</button>
                <h3 class="text-lg md:text-2xl font-black text-green-600 mb-4 md:mb-6 text-center">✨ Tambah Pasukan</h3>
                
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-3 md:space-y-5">
                    @csrf
                    <div>
                        <input type="text" name="name" placeholder="Nama Kapten" required class="w-full rounded-xl md:rounded-2xl border-2 md:border-4 border-gray-100 p-2 md:p-4 text-sm md:text-base focus:border-green-400 outline-none font-bold bg-gray-50 focus:bg-white transition">
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email" required class="w-full rounded-xl md:rounded-2xl border-2 md:border-4 border-gray-100 p-2 md:p-4 text-sm md:text-base focus:border-green-400 outline-none font-bold bg-gray-50 focus:bg-white transition">
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password" required class="w-full rounded-xl md:rounded-2xl border-2 md:border-4 border-gray-100 p-2 md:p-4 text-sm md:text-base focus:border-green-400 outline-none font-bold bg-gray-50 focus:bg-white transition">
                    </div>
                    <div>
                        <select name="role" class="w-full rounded-xl md:rounded-2xl border-2 md:border-4 border-gray-100 p-2 md:p-4 text-sm md:text-base focus:border-green-400 outline-none font-bold bg-white text-gray-600">
                            <option value="user">User Biasa 🚀</option>
                            <option value="admin">Admin 👑</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-black py-3 md:py-4 rounded-xl md:rounded-2xl shadow-md md:shadow-xl border-b-4 md:border-b-8 border-green-700 active:border-b-0 active:translate-y-1 md:active:translate-y-2 transition mt-2 text-sm md:text-lg uppercase tracking-wide">
                        Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="edit-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('edit-modal')"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[95%] md:w-[90%] max-w-lg p-3 md:p-4">
            <div class="bg-white rounded-2xl md:rounded-[2rem] border-4 md:border-8 border-yellow-200 shadow-2xl p-5 md:p-8 relative animate-bounce-in">
                <button onclick="closeModal('edit-modal')" class="absolute top-3 right-4 md:top-4 md:right-5 text-gray-300 hover:text-red-500 font-bold text-xl md:text-3xl">✕</button>
                <h3 class="text-lg md:text-2xl font-black text-yellow-600 mb-4 md:mb-6 text-center">✏️ Edit Kapten</h3>
                
                <form id="edit-form" method="POST" class="space-y-3 md:space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="text-[10px] md:text-xs font-black text-gray-400 uppercase ml-2">Nama</label>
                        <input type="text" name="name" id="edit-name" required class="w-full rounded-xl md:rounded-2xl border-2 md:border-4 border-gray-100 p-2 md:p-4 text-sm md:text-base focus:border-yellow-400 outline-none font-bold">
                    </div>
                    <div>
                        <label class="text-[10px] md:text-xs font-black text-gray-400 uppercase ml-2">Email</label>
                        <input type="email" name="email" id="edit-email" required class="w-full rounded-xl md:rounded-2xl border-2 md:border-4 border-gray-100 p-2 md:p-4 text-sm md:text-base focus:border-yellow-400 outline-none font-bold">
                    </div>
                    <div>
                        <label class="text-[10px] md:text-xs font-black text-gray-400 uppercase ml-2">Pass <span class="text-[9px] font-normal italic lowercase">(Opsional)</span></label>
                        <input type="password" name="password" class="w-full rounded-xl md:rounded-2xl border-2 md:border-4 border-gray-100 p-2 md:p-4 text-sm md:text-base focus:border-yellow-400 outline-none font-bold">
                    </div>
                    <div>
                         <label class="text-[10px] md:text-xs font-black text-gray-400 uppercase ml-2">Pangkat</label>
                        <select name="role" id="edit-role" class="w-full rounded-xl md:rounded-2xl border-2 md:border-4 border-gray-100 p-2 md:p-4 text-sm md:text-base focus:border-yellow-400 outline-none font-bold bg-white">
                            <option value="user">User Biasa 🚀</option>
                            <option value="admin">Admin 👑</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-black py-3 md:py-4 rounded-xl md:rounded-2xl shadow-md md:shadow-xl border-b-4 md:border-b-8 border-yellow-600 active:border-b-0 active:translate-y-1 md:active:translate-y-2 transition mt-2 text-sm md:text-lg uppercase tracking-wide">
                        Update Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('delete-modal')"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[85%] md:w-[90%] max-w-sm p-4">
            <div class="bg-white rounded-2xl md:rounded-[2rem] border-4 md:border-8 border-red-200 shadow-2xl p-6 md:p-8 text-center animate-bounce-in">
                <div class="text-5xl md:text-7xl mb-2 md:mb-4">😱</div>
                <h3 class="text-lg md:text-2xl font-black text-gray-800 mb-1 md:mb-2">Yakin Hapus?</h3>
                <p class="text-xs md:text-base text-gray-500 font-bold mb-4 md:mb-8">Kapten <span id="delete-name" class="text-red-500"></span> akan dikeluarkan dari pasukan!</p>
                
                <form id="delete-form" method="POST" class="flex gap-2 md:gap-4">
                    @csrf @method('DELETE')
                    <button type="button" onclick="closeModal('delete-modal')" class="flex-1 bg-gray-100 text-gray-600 font-bold py-2 md:py-3 rounded-xl md:rounded-2xl text-xs md:text-base hover:bg-gray-200 border-b-2 md:border-b-4 border-gray-300 active:border-b-0 active:translate-y-0.5 md:active:translate-y-1">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-red-500 text-white font-bold py-2 md:py-3 rounded-xl md:rounded-2xl border-b-2 md:border-b-4 border-red-700 active:border-b-0 active:translate-y-0.5 md:active:translate-y-1 text-xs md:text-base shadow-lg">
                        Hapus Aja!
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
        function openEditModal(id, name, email, role) {
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value = role;
            document.getElementById('edit-form').action = "/admin/users/" + id; 
            openModal('edit-modal');
        }
        function openDeleteModal(id, name) {
            document.getElementById('delete-name').innerText = name;
            document.getElementById('delete-form').action = "/admin/users/" + id;
            openModal('delete-modal');
        }
        document.addEventListener('DOMContentLoaded', () => {
            const success = document.getElementById('alert-success');
            const error = document.getElementById('alert-error');
            if(success) setTimeout(() => { success.style.opacity = '0'; setTimeout(() => success.remove(), 500); }, 3000);
            if(error) setTimeout(() => { error.style.opacity = '0'; setTimeout(() => error.remove(), 500); }, 3000);
        });
    </script>
</body>
</html>