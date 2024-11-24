<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'wisata_id',
        'image_path',
    ];
    protected $casts = [
        'image_path' => 'array',
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}

