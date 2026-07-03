<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Daftarkan semua kolom database kelompokmu di sini agar tidak di-blok Laravel
    protected $fillable = [
        'name',
        'category_id', // Database meminta ini
        'location',
        'type',
        'photo',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}