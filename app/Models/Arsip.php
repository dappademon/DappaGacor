<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Penduduk;
 
class Arsip extends Model
{
    protected $table = 'arsips';
 
    protected $fillable = [
        'archive_number', 'title', 'category_id', 'resident_id',
        'user_id', 'document_date', 'sender_receiver',
        'file_path', 'notes'
    ];
 
    protected $casts = ['document_date' => 'date'];
 
    // Relasi ke Kategori (Many arsip -> One kategori)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }
 
    // Relasi ke Penduduk (Many arsip -> One penduduk, nullable)
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'resident_id');
    }
 
    // Relasi ke User/Staff yang upload
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

