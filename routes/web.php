<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\ChatController; // Pastikan ini ada
use App\Models\Project;
use App\Models\Chat; // WAJIB ADA: Biar bisa ambil data history
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// --- ROUTE DASHBOARD (DIPERBAIKI) ---
Route::get('/dashboard', function () {
    // 1. Ambil History
    $histories = [];
    if (Auth::check()) {
        $histories = \App\Models\Chat::where('user_id', Auth::id())->latest()->get();
    }
    
    // 2. Kirim Data Lengkap (Supaya dashboard tidak bingung)
    return view('dashboard', [
        'histories' => $histories,
        'messages' => collect([]), // Penting: list pesan kosong
        'currentChat' => null      // Penting: tidak ada chat aktif
    ]);

})->middleware(['auth', 'verified'])->name('dashboard');


// --- GROUP ROUTE UTAMA (YANG BUTUH LOGIN) ---
Route::middleware(['auth'])->group(function () {

    // 1. Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Fitur Chat & AI (Gunakan ChatController yang sudah kita buat)
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');       // New Chat
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');    // Buka History Lama
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send'); // Kirim Pesan Biasa
    Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.delete'); // Hapus Chat

    // Route Khusus AJAX AI (Sesuaikan dengan nama route di JavaScript kamu)
    // Jika di script JS kamu panggil 'ai.chat', arahkan ke sini:
    Route::post('/ai-chat', [ChatController::class, 'sendMessage'])->name('ai.chat'); 
    
    // Opsi: Jika kamu punya Controller terpisah khusus AI, pakai baris ini (pilih salah satu):
    // Route::post('/ai/generate', [AiController::class, 'generate'])->name('ai.generate');
});


// --- GROUP ROUTE ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin.index');
    
    Route::post('/admin/ai-toggle', [AdminController::class, 'toggleAI'])->name('admin.ai.toggle');

    // ROUTE BARU: Update Persona
    Route::post('/admin/update-prompt', [AdminController::class, 'updatePrompt'])->name('admin.prompt.update');

    // RUTE BARU UNTUK USER MANAGEMENT
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

require __DIR__.'/auth.php';