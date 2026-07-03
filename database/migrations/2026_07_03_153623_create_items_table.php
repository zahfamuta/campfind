<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('category');
            $table->string('location');
            $table->string('type')->default('found'); // Sesuai flowchart: jenis found
            $table->string('photo')->nullable();
            $table->string('status')->default('Tunggu Konfirmasi Pemilik'); // Sesuai teks di flowchart
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang melaporkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};