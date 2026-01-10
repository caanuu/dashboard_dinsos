<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class PublicController extends Controller
{
    // Halaman Cek Resi
    public function tracking(Request $request)
    {
        $result = null;

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            // Cari berdasarkan Nomor Tiket
            $result = Application::with(['resident', 'serviceType', 'logs'])
                        ->where('nomor_tiket', $keyword)
                        ->first();
        }

        return view('tracking', compact('result'));
    }
}
