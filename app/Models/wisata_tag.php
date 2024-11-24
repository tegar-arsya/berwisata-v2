<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class wisata_tag extends Model
{
    //
    use HasFactory;
    protected $fillable = ['wisata_id', 'tag_id'];

     // Relasi ke Tag
     public function tags()
     {
         return $this->belongsTo(Tag::class, 'tag_id');
     }

     // Relasi ke Wisata
     public function wisatas()
     {
         return $this->belongsTo(Wisata::class, 'wisata_id');
     }
}
