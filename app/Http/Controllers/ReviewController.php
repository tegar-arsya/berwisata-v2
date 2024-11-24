<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $wisata_id)
    {
        // Validasi input
        $request->validate([
            'nama_pengunjung' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        // Simpan review
        Review::create([
            'wisata_id' => $wisata_id,
            'nama_pengunjung' => $request->nama_pengunjung,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        // Redirect kembali ke halaman wisata dengan pesan sukses
        return response()->json(['message' => 'Review berhasil ditambahkan!'], 200);
    }
}
