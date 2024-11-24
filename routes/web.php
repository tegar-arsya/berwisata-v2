<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\ReviewController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WisataController::class, 'index'])->name('home');
Route::get('/wisata/{id}', [WisataController::class, 'show'])->name('wisata.detail');
Route::post('/wisata/{wisata}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
