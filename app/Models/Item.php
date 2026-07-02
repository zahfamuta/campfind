<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'type',
        'location',
        'date_time',
        'image',
        'status'
    ];

    // Relasi: Barang ini milik (dilaporkan oleh) seorang User (Finder)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Barang ini termasuk dalam suatu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Barang ini bisa memiliki beberapa klaim (jika banyak yang merasa memiliki)
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}