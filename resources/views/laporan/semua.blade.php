<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Semua Tagihan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3>Laporan Semua Tagihan</h3>
    <table>
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah Meter</th>
                <th>Status</th>
                <th>Tanggal Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tagihan as $t)
            <tr>
                <td>{{ $t->pelanggan->nama_pelanggan ?? '-' }}</td>
                <td>{{ $t->bulan }}</td>
                <td>{{ $t->tahun }}</td>
                <td>{{ $t->jumlah_meter }}</td>
                <td>{{ $t->status }}</td>
                <td>{{ $t->tanggal_jatuh_tempo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
