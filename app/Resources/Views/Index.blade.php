<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pemohon - Reklame Online</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h1>Sistem Perizinan Reklame Online</h1>
            <p>Selamat Datang, <strong>Budi Santoso</strong></p>
        </header>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 10px; margin-bottom: 20px;">{{ session('success') }}</div>
        @endif

        <section class="upload-section">
            <h3>Ajukan Permohonan Baru</h3>
            <form action="{{ route('permohonan.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 10px;">
                    <label>Upload KTP (PDF/JPG):</label><br>
                    <input type="file" name="dokumen_ktp" required>
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Foto Rencana Lokasi:</label><br>
                    <input type="file" name="foto_lokasi" required>
                </div>
                <button type="submit" class="btn-primary">Kirim Pengajuan</button>
            </form>
        </section>

        <section class="history">
            <h3>Riwayat Permohonan Anda</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Permohonan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permohonan as $p)
                    <tr>
                        <td>{{ $p->id_permohonan }}</td>
                        <td>{{ $p->tanggal_pengajuan }}</td>
                        <td><span class="badge">{{ $p->status }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
