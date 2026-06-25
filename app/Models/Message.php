<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Pesan ini milik 1 Obrolan
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}