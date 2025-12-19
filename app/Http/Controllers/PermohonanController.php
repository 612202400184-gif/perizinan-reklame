<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanIzin;
use App\Models\Dokumen;
use App\Models\Survey;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    // --- SISI PEMOHON ---

    // Menampilkan Dashboard Pemohon
    public function index()
    {
        // Mengambil semua data permohonan untuk riwayat
        $permohonan = PermohonanIzin::orderBy('created_at', 'desc')->get();
        return view('index', compact('permohonan'));
    }

    // Proses Pengajuan Izin Baru & Upload Dokumen
    public function store(Request $request)
    {
        $request->validate([
            'dokumen_ktp' => 'required|mimes:pdf,jpg,png|max:2048',
            'foto_lokasi' => 'required|image|max:2048',
        ]);

        // Generate ID unik sesuai format (contoh: REG-170425)
        $id_permohonan = 'REG-' . date('dmy') . rand(100, 999);

        // 1. Simpan Data Permohonan
        PermohonanIzin::create([
            'id_permohonan' => $id_permohonan,
            'tanggal_pengajuan' => now(),
            'status' => 'Pending'
        ]);

        // 2. Simpan & Catat Dokumen KTP
        if ($request->hasFile('dokumen_ktp')) {
            $pathKtp = $request->file('dokumen_ktp')->store('public/dokumen');
            Dokumen::create([
                'id_dokumen' => 'DOC-KTP-' . time(),
                'id_permohonan' => $id_permohonan,
                'tipe_dokumen' => 'KTP',
                'filePath' => str_replace('public/', '', $pathKtp)
            ]);
        }

        // 3. Simpan & Catat Foto Lokasi
        if ($request->hasFile('foto_lokasi')) {
            $pathFoto = $request->file('foto_lokasi')->store('public/dokumen');
            Dokumen::create([
                'id_dokumen' => 'DOC-LOK-' . time(),
                'id_permohonan' => $id_permohonan,
                'tipe_dokumen' => 'Foto Lokasi',
                'filePath' => str_replace('public/', '', $pathFoto)
            ]);
        }

        return redirect()->back()->with('success', 'Permohonan ' . $id_permohonan . ' berhasil dikirim!');
    }


    // --- SISI ADMIN ---

    // Menampilkan Daftar Verifikasi untuk Admin
    public function adminDashboard()
    {
        $permohonan = PermohonanIzin::with('dokumens')->get();
        return view('admin.dashboard', compact('permohonan'));
    }

    // Proses Verifikasi Dokumen oleh Admin
    public function verifikasi($id)
    {
        $p = PermohonanIzin::findOrFail($id);
        // Status berubah ke 'Survey' agar muncul di dashboard petugas
        $p->update(['status' => 'Survey']);
        
        return redirect()->back()->with('info', 'Dokumen terverifikasi. Perintah Survey diterbitkan.');
    }


    // --- SISI PETUGAS LAPANGAN ---

    // Menampilkan Tugas Survey
    public function petugasDashboard()
    {
        $tugas = PermohonanIzin::where('status', 'Survey')->get();
        return view('petugas.index', compact('tugas'));
    }

    // Input Hasil Survey Lapangan
    public function simpanSurvey(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'required',
            'hasil_survey' => 'required',
        ]);

        // Simpan ke tabel surveys
        Survey::create([
            'id_survey' => 'SRV-' . time(),
            'id_permohonan' => $id,
            'lokasi' => $request->lokasi,
            'hasil_survey' => $request->hasil_survey,
            'tanggal_survey' => now(),
        ]);

        // Update status ke 'Approval' (menunggu Kepala Dinas)
        PermohonanIzin::where('id_permohonan', $id)->update(['status' => 'Approval']);

        return redirect('/petugas')->with('success', 'Hasil survey berhasil dikirim ke Kepala Dinas.');
    }
}
