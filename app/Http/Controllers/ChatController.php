<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Project;
use App\Models\Setting; // <--- WAJIB DITAMBAHKAN: Panggil Model Setting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        $histories = Chat::where('user_id', Auth::id())
                        ->orderBy('updated_at', 'desc')
                        ->get();

        // Cek class Project untuk hindari error jika belum ada
        $totalProjects = class_exists(Project::class) ? Project::count() : 0;

        return view('dashboard', [
            'histories' => $histories,
            'currentChat' => null,
            'messages' => collect([]),
            'totalProjects' => $totalProjects
        ]);
    }

    public function show($id)
    {
        $chat = Chat::findOrFail($id);
        
        if ($chat->user_id !== Auth::id()) {
            abort(403);
        }

        $histories = Chat::where('user_id', Auth::id())
                        ->orderBy('updated_at', 'desc') 
                        ->get();

        $messages = Message::where('chat_id', $id)->orderBy('created_at', 'asc')->get();

        return view('dashboard', [
            'histories' => $histories,
            'currentChat' => $chat,
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required']);
        $userMessage = $request->input('message');
        $chatId = $request->input('chat_id');

        if (!$chatId) {
            $chat = Chat::create([
                'user_id' => Auth::id(),
                'title' => Str::limit($userMessage, 25, '...')
            ]);
            $chatId = $chat->id;
        } else {
            $chat = Chat::find($chatId);
            $chat->touch(); 
        }

        Message::create([
            'chat_id' => $chatId,
            'role' => 'user',
            'content' => $userMessage
        ]);

        $apiKey = env('GROQ_API_KEY');
        $botReply = "Maaf Kapten, sinyal terputus...";

        if ($apiKey) {
            try {
                $dbHistory = Message::where('chat_id', $chatId)
                    ->latest()
                    ->take(10)
                    ->get()
                    ->reverse()
                    ->map(function ($msg) {
                        return [
                            'role' => ($msg->role === 'ai' || $msg->role === 'assistant') ? 'assistant' : 'user',
                            'content' => $msg->content
                        ];
                    })->toArray();

                // --- [BAGIAN INI YANG DIUBAH MENJADI DINAMIS] ---
                
                // 1. Ambil Data dari Database Setting
                $setting = Setting::first();
                
                // 2. Siapkan Default (Jaga-jaga kalau admin belum isi apa-apa)
                $defaultPersona = "PERAN: Kamu adalah 'Gado2ai', robot sahabat anak-anak SD yang ceria, lucu, dan pintar.
                    ATURAN WAJIB:
                    1. JANGAN PERNAH menyebut kata: 'Laravel', 'Coding', 'AI', 'Model Bahasa'.
                    2. Jawablah dengan bahasa Indonesia yang santai, seru, dan mudah dimengerti anak kecil.
                    3. Panggil pengguna dengan sebutan 'Kapten'.
                    4. Jawaban harus PENDEK (maksimal 3-4 kalimat).
                    TUJUAN: Membuat anak-anak senang belajar.";

                // 3. Gunakan Prompt dari DB jika ada, jika kosong pakai Default
                $finalPrompt = $setting->system_prompt ?? $defaultPersona;

                $systemMessage = [
                    'role' => 'system',
                    'content' => $finalPrompt
                ];
                // ------------------------------------------------

                $messagesToSend = array_merge([$systemMessage], $dbHistory);

                $response = Http::withToken($apiKey)
                    ->timeout(60)
                    ->retry(3, 100)
                    ->withoutVerifying()
                    ->withOptions(['force_ip_resolve' => 'v4'])
                    ->post('https://api.groq.com/openai/v1/chat/completions', [
                        'model' => 'llama-3.3-70b-versatile', 
                        'messages' => $messagesToSend,
                        'temperature' => 0.7,
                        'max_tokens' => 300,
                    ]);

                if ($response->successful()) {
                    $botReply = $response->json()['choices'][0]['message']['content'];
                } else {
                    Log::error('Groq Error: ' . $response->body());
                    $botReply = "Waduh, sinyal antar galaksi putus! Coba lagi ya Kapten 📡";
                }

            } catch (\Exception $e) {
                Log::error('Controller Error: ' . $e->getMessage());
                $botReply = "Sistemku lagi pusing. 😵‍💫 Eror: " . $e->getMessage();
            }
        }

        Message::create([
            'chat_id' => $chatId,
            'role' => 'ai',
            'content' => $botReply
        ]);

        return response()->json([
            'chat_id' => $chatId,
            'reply' => $botReply
        ]);
    }

    public function destroy($id) {
        Chat::where('user_id', Auth::id())->where('id', $id)->delete();
        return redirect()->route('chat.index'); 
    }
}