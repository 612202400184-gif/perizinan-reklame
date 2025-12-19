<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Petugas - Survey Lapangan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h2>Tugas Survey Lapangan</h2>
        @foreach($tugas as $t)
        <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px;">
            <h4>ID: {{ $t->id_permohonan }}</h4>
            <form action="{{ route('petugas.survey.simpan', $t->id_permohonan) }}" method="POST">
                @csrf
                <input type="text" name="lokasi" placeholder="Alamat Detail Lokasi" required style="width: 100%; margin-bottom: 10px;">
                <textarea name="hasil_survey" placeholder="Hasil Survey (Kelayakan)" required style="width: 100%; margin-bottom: 10px;"></textarea>
                <button type="submit" class="btn-primary">Kirim Hasil Survey</button>
            </form>
        </div>
        @endforeach
    </div>
</body>
</html>
