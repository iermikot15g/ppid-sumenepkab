<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Dokumen DIP</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #666; }
        .filters { margin-bottom: 20px; padding: 10px; background: #f3f4f6; }
        .stats { margin-bottom: 20px; }
        .stats table { width: 100%; border-collapse: collapse; }
        .stats td { padding: 5px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.data th { background-color: #f3f4f6; font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DOKUMEN DAFTAR INFORMASI PUBLIK (DIP)</h1>
        <p>PPID Kabupaten Sumenep</p>
        <p>Dinas Komunikasi dan Informatika Kabupaten Sumenep</p>
    </div>

    <div class="filters">
        <strong>Filter Laporan:</strong><br>
        OPD: {{ $filters['opd'] }}<br>
        Periode: {{ $filters['start_date'] }} s/d {{ $filters['end_date'] }}<br>
        Tahun: {{ $filters['year'] }}<br>
        Tanggal Generate: {{ $filters['generated_at'] }}
    </div>

    <div class="stats">
        <strong>Ringkasan Statistik:</strong>
        <table style="width: 100%; margin-top: 5px;">
            <tr>
                <td style="width: 25%;">Total Dokumen:</td>
                <td><strong>{{ $stats['total'] }}</strong></td>
                <td style="width: 25%;">Terpublikasi:</td>
                <td><strong>{{ $stats['published'] }}</strong></td>
            </tr>
            <tr>
                <td>Belum Publikasi:</td>
                <td><strong>{{ $stats['unpublished'] }}</strong></td>
                <td>Diarsipkan:</td>
                <td><strong>{{ $stats['archived'] }}</strong></td>
            </tr>
            <tr>
                <td>Klasifikasi Terbuka:</td>
                <td><strong>{{ $stats['open'] }}</strong></td>
                <td>Klasifikasi Dikecualikan:</td>
                <td><strong>{{ $stats['excluded'] }}</strong></td>
            </tr>
            <tr>
                <td colspan="3">Total Unduhan:</td>
                <td><strong>{{ $stats['total_downloads'] }}</strong></td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Dokumen</th>
                <th>OPD</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Klasifikasi</th>
                <th>Status</th>
                <th>Unduhan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $index => $doc)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $doc->title }}</td>
                <td>{{ $doc->opd->name ?? '-' }}</td>
                <td>{{ $doc->category->name ?? '-' }}</td>
                <td>{{ $doc->year }}</td>
                <td>{{ $doc->classification === 'open' ? 'Terbuka' : 'Dikecualikan' }}</td>
                <td>{{ ucfirst($doc->status) }}</td>
                <td>{{ $doc->download_count }}</td>
            </tr>
            @endforeach
            @if($documents->isEmpty())
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem PPID Kabupaten Sumenep</p>
    </div>
</body>
</html>