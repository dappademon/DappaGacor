<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\Arsip;
 
class Penduduk extends Model
{
    protected $table = 'penduduks';
 
    protected $fillable = ['nik', 'name', 'address'];
 
    // Relasi: satu penduduk bisa punya banyak arsip
    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'resident_id');
    }
}

