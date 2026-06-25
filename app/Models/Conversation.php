<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: 1 Obrolan punya BANYAK Pesan
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // 🔥 INI DIA YANG TADI KELUPAAN 🔥
    // Relasi: 1 Obrolan ini miliknya 1 Pelanggan (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}