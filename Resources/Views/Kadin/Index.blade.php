<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kepala Dinas - Approval</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h2>Persetujuan Kepala Dinas</h2>
        @foreach($persetujuan as $p)
        <div style="border: 2px solid #2563eb; padding: 20px; margin-bottom: 20px;">
            <h3>Permohonan: {{ $p->id_permohonan }}</h3>
            <p><strong>Hasil Survey:</strong> {{ $p->survey->hasil_survey }}</p>
            <p><strong>Lokasi:</strong> {{ $p->survey->lokasi }}</p>
            
            <form action="{{ route('kadin.approve', $p->id_permohonan) }}" method="POST">
                @csrf
                <button type="submit" class="btn-primary" style="background: #1e40af;">Setujui & Terbitkan Izin</button>
            </form>
        </div>
        @endforeach
    </div>
</body>
</html>
