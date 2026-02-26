<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            AI Edukasi Anak
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        @if(session('error'))
            <div class="text-red-600 mb-4">{{ session('error') }}</div>
        @endif

       <form method="POST" action="{{ route('ai.generate') }}">
            @csrf

            <textarea name="prompt" rows="5" required></textarea>

            <button type="submit">Kirim</button>
        </form>


        @isset($result)
            <hr class="my-6">
            <h3 class="font-bold mb-2">Jawaban AI:</h3>
            <p class="whitespace-pre-line">{{ $result }}</p>
        @endisset
    </div> 
</x-app-layout>
