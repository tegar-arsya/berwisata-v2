<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Tag extends Model
{
    //
    use HasFactory;
    protected $fillable = ['nama_tag'];

    // Relasi many-to-many antara Tag dan Wisata
    public function wisatas()
    {
        return $this->belongsToMany(Wisata::class, 'wisata_tags');
    }
}
