<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik PPID - {{ $data['opd_name'] }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .header p {
            margin: 5px 0;
            font-size: 11px;
            color: #777;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px 10px;
            margin-bottom: 10px;
            border-left: 4px solid #2563eb;
        }
        .stats-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-card {
            flex: 1;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }
        .stat-card .label {
            font-size: 11px;
            color: #666;
        }
        .stat-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-green {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-yellow {
            background-color: #fef3c7;
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN STATISTIK DOKUMEN DIP</h1>
        <h2>PPID Kabupaten Sumenep</h2>
        <p>OPD: {{ $data['opd_name'] }}</p>
        <p>Tanggal Cetak: {{ $data['generated_at']->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Filter Info -->
    @if($data['period']['start'] || $data['period']['end'] || $data['year'])
    <div class="section">
        <div style="background-color: #eff6ff; padding: 8px; border-radius: 5px;">
            <strong>Filter yang diterapkan:</strong>
            @if($data['period']['start']) Periode: {{ \Carbon\Carbon::parse($data['period']['start'])->format('d/m/Y') }} 
                @if($data['period']['end']) s.d. {{ \Carbon\Carbon::parse($data['period']['end'])->format('d/m/Y') }} @endif
            @endif
            @if($data['year']) | Tahun: {{ $data['year'] }} @endif
        </div>
    </div>
    @endif

    <!-- Statistik Ringkasan -->
    <div class="section">
        <div class="section-title">RINGKASAN STATISTIK</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Total Dokumen</div>
                <div class="value">{{ number_format($data['total_documents']) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Dipublikasikan</div>
                <div class="value">{{ number_format($data['published_documents']) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Belum Dipublikasi</div>
                <div class="value">{{ number_format($data['unpublished_documents']) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Total Unduhan</div>
                <div class="value">{{ number_format($data['total_downloads']) }}</div>
            </div>
        </div>
    </div>

    <!-- Klasifikasi Informasi -->
    <div class="section">
        <div class="section-title">KLASIFIKASI INFORMASI</div>
        <table>
            <tr>
                <th>Klasifikasi</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
            <tr>
                <td>Informasi Terbuka (Open)</td>
                <td>{{ number_format($data['open_documents']) }}</td>
                <td>{{ $data['total_documents'] > 0 ? round(($data['open_documents'] / $data['total_documents']) * 100, 2) : 0 }}%</td>
            </tr>
            <tr>
                <td>Informasi Dikecualikan (Excluded)</td>
                <td>{{ number_format($data['excluded_documents']) }}</td>
                <td>{{ $data['total_documents'] > 0 ? round(($data['excluded_documents'] / $data['total_documents']) * 100, 2) : 0 }}%</td>
            </tr>
        </table>
    </div>

    <!-- Statistik per Kategori Utama -->
    <div class="section">
        <div class="section-title">STATISTIK PER KATEGORI UTAMA</div>
        <table>
            <tr>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
            @foreach($data['category_stats'] as $stat)
            <tr>
                <td>{{ $stat->name }}</td>
                <td>{{ number_format($stat->total) }}</td>
                <td>{{ $data['total_documents'] > 0 ? round(($stat->total / $data['total_documents']) * 100, 2) : 0 }}%</td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Tren Bulanan -->
    <div class="section">
        <div class="section-title">TREN PUBLIKASI & UNDUHAN PER BULAN</div>
        <table>
            <tr>
                <th>Bulan</th>
                <th>Jumlah Publikasi</th>
                <th>Jumlah Unduhan</th>
            </tr>
            @foreach($data['monthly_stats'] as $stat)
            <tr>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $stat->month)->format('F Y') }}</td>
                <td>{{ number_format($stat->total) }}</td>
                <td>{{ number_format($stat->downloads) }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- 10 Dokumen Terpopuler -->
    <div class="section">
        <div class="section-title">10 DOKUMEN PALING BANYAK DIUNDUH</div>
        <table>
            <tr>
                <th>No</th>
                <th>Judul Dokumen</th>
                <th>Jumlah Unduhan</th>
                <th>Tanggal Upload</th>
            </tr>
            @foreach($data['top_documents'] as $index => $doc)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $doc->title }}</td>
                <td>{{ number_format($doc->download_count) }}</td>
                <td>{{ \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="footer">
        Laporan ini dibuat secara otomatis oleh Sistem PPID Kabupaten Sumenep.
        Dokumen ini sah tanpa tanda tangan.
    </div>
</body>
</html>