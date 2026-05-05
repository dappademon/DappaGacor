<?php
namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Arsip;
 
class User extends Authenticatable
{
    use Notifiable;
 
    protected $fillable = ['name', 'email', 'password', 'role'];
 
    protected $hidden = ['password', 'remember_token'];
 
    protected $casts = ['password' => 'hashed'];
 
    // Relasi: satu user bisa upload banyak arsip
    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'user_id');
    }
 
    // Helper method cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
 
    public function isKades(): bool
    {
        return $this->role === 'kades';
    }
}

