<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\Arsip;
 
class Kategori extends Model
{
    protected $table = 'kategoris';
 
    protected $fillable = ['name', 'description'];
 
    // Relasi: satu kategori punya banyak arsip
    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'category_id');
    }
}

