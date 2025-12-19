<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanIzin;
use App\Models\Dokumen;
use App\Models\Survey;
use App\Models\Izin;
use Illuminate\Support\Facades\DB;

class PermohonanController extends Controller
{
    // ==========================================
    // 1. SISI PEMOHON
    // ==========================================

    // Dashboard Pemohon & Riwayat
    public function index()
    {
        $permohonan = PermohonanIzin::orderBy('created_at', 'desc')->get();
        return view('index', compact('permohonan'));
    }

    // Proses Simpan Pengajuan Baru
    public function store(Request $request)
    {
        $request->validate([
            'dokumen_ktp' => 'required|mimes:pdf,jpg,png|max:2048',
            'foto_lokasi' => 'required|image|max:2048',
        ]);

        $id_permohonan = 'REG-' . strtoupper(bin2hex(random_bytes(3)));

        // Gunakan Transaction untuk memastikan data tersimpan semua
        DB::transaction(function () use ($request, $id_permohonan) {
            // Simpan Permohonan
            PermohonanIzin::create([
                'id_permohonan' => $id_permohonan,
                'tanggal_pengajuan' => now(),
                'status' => 'Pending'
            ]);

            // Simpan Dokumen KTP
            $pathKtp = $request->file('dokumen_ktp')->store('public/dokumen');
            Dokumen::create([
                'id_dokumen' => 'DOC-KTP-' . time(),
                'id_permohonan' => $id_permohonan,
                'tipe_dokumen' => 'KTP',
                'filePath' => str_replace('public/', '', $pathKtp)
            ]);

            // Simpan Foto Lokasi
            $pathFoto = $request->file('foto_lokasi')->store('public/dokumen');
            Dokumen::create([
                'id_dokumen' => 'DOC-LOK-' . time(),
                'id_permohonan' => $id_permohonan,
                'tipe_dokumen' => 'Foto Lokasi',
                'filePath' => str_replace('public/', '', $pathFoto)
            ]);
        });

        return redirect()->route('pemohon.dashboard')->with('success', 'Permohonan berhasil dikirim!');
    }

    // ==========================================
    // 2. SISI ADMIN
    // ==========================================

    public function adminDashboard()
    {
        $permohonan = PermohonanIzin::with('dokumens')->get();
        return view('admin.dashboard', compact('permohonan'));
    }

    public function verifikasi($id)
    {
        $p = PermohonanIzin::findOrFail($id);
        $p->update(['status' => 'Survey']);
        return redirect()->back()->with('info', 'Verifikasi berhasil. Status: Survey Lapangan.');
    }

    // ==========================================
    // 3. SISI PETUGAS LAPANGAN
    // ==========================================

    public function petugasDashboard()
    {
        $tugas = PermohonanIzin::where('status', 'Survey')->get();
        return view('petugas.index', compact('tugas'));
    }

    public function simpanSurvey(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'required',
            'hasil_survey' => 'required',
        ]);

        Survey::create([
            'id_survey' => 'SRV-' . time(),
            'id_permohonan' => $id,
            'lokasi' => $request->lokasi,
            'hasil_survey' => $request->hasil_survey,
            'tanggal_survey' => now(),
        ]);

        PermohonanIzin::where('id_permohonan', $id)->update(['status' => 'Approval']);

        return redirect()->route('petugas.dashboard')->with('success', 'Hasil survey terkirim ke Kepala Dinas.');
    }

    // ==========================================
    // 4. SISI KEPALA DINAS (KADIN) - TERBARU
    // ==========================================

    // Menampilkan daftar permohonan yang menunggu persetujuan akhir
    public function kadinDashboard()
    {
        // Mengambil data yang statusnya 'Approval' beserta data survey-nya
        $persetujuan = PermohonanIzin::where('status', 'Approval')
                        ->with(['survey', 'dokumens'])
                        ->get();
        return view('kadin.index', compact('persetujuan'));
    }

    // Proses Approval oleh Kepala Dinas
    public function approvePermohonan($id)
    {
        $p = PermohonanIzin::findOrFail($id);
        
        // Update status menjadi 'Siap Bayar' sesuai alur sistem
        $p->update(['status' => 'Siap Bayar']);

        return redirect()->route('kadin.dashboard')->with('success', 'Permohonan ' . $id . ' telah disetujui secara resmi.');
    }
}
