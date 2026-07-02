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
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        // Hubungan ke tabel users (Finder)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        // Hubungan ke tabel categories
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        $table->string('title');
        $table->text('description');
        $table->enum('type', ['lost', 'found'])->default('found');
        $table->string('location');
        $table->dateTime('date_time');
        $table->string('image')->nullable();
        $table->enum('status', ['active', 'completed'])->default('active');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
