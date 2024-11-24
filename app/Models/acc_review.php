<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class acc_review extends Model
{
    //
    use HasFactory;

    protected $fillable = ['review_id', 'status'];

    public function review()
{
    return $this->belongsTo(Review::class);
}
}
