<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\attributse\fillable;
use Illuminate\Database\Eloquent\attributse\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // --- 1. TAMBAHKAN INI (Menggantikan baris atribut #[Fillable] bawaan jika ada, atau taruh di sini) ---
    protected $fillable = [
        'identity_number',
        'name',
        'email',
        'password',
        'phone_number',
        'role',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- 2. TAMBAHKAN FUNGSI-FUNGSI RELASI INI DI BAWAHNYA ---
    
    // Relasi: Satu user bisa memiliki banyak barang yang dilaporkan (Finder)
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // Relasi: Satu user bisa memiliki banyak klaim barang (Loser)
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    // Relasi: Satu user bisa memicu banyak log aktivitas
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
