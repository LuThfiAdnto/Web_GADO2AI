<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'ai_active',
        'system_prompt', // <--- Tambahkan ini ke dalam fillable
    ];
}