<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Wisata extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_wisata',
        'deskripsi',
        'alamat',
        'latitude',
        'longitude',
        'kategori_id',
    ];
    // Relasi satu wisata memiliki satu kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi many-to-many antara Wisata dan Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'wisata_tags');
    }
    // Relasi satu wisata memiliki banyak gambar
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    // Relasi satu wisata memiliki banyak review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
