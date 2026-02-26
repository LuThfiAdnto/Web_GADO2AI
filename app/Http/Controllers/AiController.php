<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting; // <--- WAJIB DITAMBAHKAN

class AiController extends Controller
{
    public function reply(Request $request)
    {
        $apiKey = env('GROQ_API_KEY'); 
        $userMessage = $request->input('message');

        if (in_array(strtolower($userMessage), ['reset', 'hapus', 'ulang', 'mulai ulang'])) {
            session()->forget('chat_history');
            return response()->json(['reply' => 'Sip Kapten! Ingatanku sudah bersih. Ayo mulai petualangan baru! 🚀✨']);
        }

        $history = session()->get('chat_history', []);

        // --- [BAGIAN INI YANG DIUBAH MENJADI DINAMIS] ---
        $setting = Setting::first();
        
        $defaultPersona = "PERAN: Kamu adalah 'Gado2ai', robot sahabat anak-anak SD yang ceria. 
        ATURAN: Jawab pendek, seru, jangan teknis, panggil 'Kapten'.";

        $finalPrompt = $setting->system_prompt ?? $defaultPersona;

        $systemMessage = [
            'role' => 'system',
            'content' => $finalPrompt
        ];
        // ------------------------------------------------

        $messagesToSend = array_merge([$systemMessage], $history);
        $messagesToSend[] = ['role' => 'user', 'content' => $userMessage];

        try {
            $response = Http::withToken($apiKey)
                ->withoutVerifying() // Tambahan keamanan lokal
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile', 
                    'messages' => $messagesToSend, 
                    'temperature' => 0.7, 
                    'max_tokens' => 300,  
                ]);

            if ($response->failed()) {
                Log::error('Groq API Error: ' . $response->body());
                return response()->json(['reply' => 'Waduh, sinyal antar galaksi putus! Coba lagi ya Kapten 📡'], 500);
            }

            $data = $response->json();
            $botReply = $data['choices'][0]['message']['content'] ?? 'Hmm, aku lagi melamun. Tanya lagi dong!';

            $history[] = ['role' => 'user', 'content' => $userMessage];
            $history[] = ['role' => 'assistant', 'content' => $botReply];

            if (count($history) > 20) {
                $history = array_slice($history, -20);
            }

            session()->put('chat_history', $history);

            return response()->json(['reply' => $botReply]);

        } catch (\Exception $e) {
            Log::error('Controller Error: ' . $e->getMessage());
            return response()->json(['reply' => 'Maaf Kapten, sistemku lagi pusing. 😵‍💫'], 500);
        }
    }
}