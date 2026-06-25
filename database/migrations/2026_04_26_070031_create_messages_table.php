<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Menyambungkan pesan ke ruang tamunya
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            
            // Siapa yang ngirim? Kalau admin, is_admin jadi true
            $table->unsignedBigInteger('sender_id')->nullable(); 
            $table->boolean('is_admin')->default(false); 
            
            // Isi pesan dan status baca
            $table->text('body');
            $table->boolean('is_read')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
