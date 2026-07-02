<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('claims', function (Blueprint $table) {
        $table->id();
        $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Loser
        $table->enum('return_method', ['whatsapp', 'prodi']);
        $table->string('claim_code')->nullable(); // Diisi acak jika pilih prodi
        $table->enum('claim_status', ['pending', 'approved'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
