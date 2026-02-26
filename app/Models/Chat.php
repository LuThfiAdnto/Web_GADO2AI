<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    // app/Models/Chat.php
    protected $fillable = ['user_id', 'title']; // Pastikan 'title' ada di sini!

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Pesan (Messages)
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}