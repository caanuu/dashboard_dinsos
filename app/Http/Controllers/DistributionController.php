<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;

class DistributionController extends Controller
{
    // Jadwalkan Penyaluran (Hanya untuk yang status Approved)
    public function store(Request $request)
    {
        $request->validate([
            'application_id' => 'required',
            'tanggal_penyaluran' => 'required|date',
            'lokasi_penyaluran' => 'required|string'
        ]);

        Distribution::create([
            'application_id' => $request->application_id,
            'tanggal_penyaluran' => $request->tanggal_penyaluran,
            'lokasi_penyaluran' => $request->lokasi_penyaluran,
            'status_realisasi' => 'terjadwal'
        ]);

        return back()->with('success', 'Jadwal penyaluran berhasil dibuat.');
    }

    // Realisasi (Upload Bukti Terima)
    public function update(Request $request, $id)
    {
        $dist = Distribution::findOrFail($id);

        $request->validate([
            'bukti_penyaluran' => 'required|image|max:2048'
        ]);

        $path = $request->file('bukti_penyaluran')->store('bukti_distribusi', 'public');

        $dist->update([
            'bukti_penyaluran' => $path,
            'status_realisasi' => 'disalurkan',
            'catatan' => $request->catatan
        ]);

        // Update Status Utama Aplikasi jadi SELESAI/DISTRIBUTED
        $dist->application->update(['status' => 'distributed']);

        return back()->with('success', 'Bantuan berhasil disalurkan.');
    }
}
