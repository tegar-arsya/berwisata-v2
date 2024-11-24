<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'wisata_id',
        'nama_pengunjung',
        'rating',
        'komentar',
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
    public function accReview()
{
    return $this->hasOne(acc_review::class);
}
}
