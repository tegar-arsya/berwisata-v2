<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Wisata;
use App\Models\Kategori;
use App\Models\Review;
use App\Models\acc_review;
use App\Models\Faq;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori untuk dropdown
        $kategoris = Kategori::all();
        $faqs = Faq::all();
        // Ambil kategori dari request jika ada
        $kategoriId = $request->input('kategori_id');

        // Ambil semua wisata atau berdasarkan kategori
        $wisatas = $kategoriId ?
            Wisata::where('kategori_id', $kategoriId)->with(['kategori', 'tags', 'images', 'reviews' => function($query) {
                $query->whereHas('accReview'); // Hanya ambil review yang disetujui
            }])->get() :
            Wisata::with(['kategori', 'tags', 'images', 'reviews' => function($query) {
                $query->whereHas('accReview'); // Hanya ambil review yang disetujui
            }])->get();

        return view('welcome', compact('wisatas', 'kategoris', 'faqs'));
    }

    public function show($id)
{
    // Ambil wisata berdasarkan ID
    $wisata = Wisata::with(['kategori', 'tags', 'images', 'reviews' => function($query) {
        $query->whereHas('accReview'); // Hanya ambil review yang disetujui
    }])->findOrFail($id);

    return view('wisata.detail', compact('wisata'));
}
}
