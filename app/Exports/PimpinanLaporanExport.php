<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PimpinanLaporanExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [];
        
        // Header laporan
        $rows[] = ['LAPORAN STATISTIK DOKUMEN DIP'];
        $rows[] = ['PPID Kabupaten Sumenep'];
        $rows[] = ['OPD: ' . $this->data['opd_name']];
        $rows[] = ['Tanggal Cetak: ' . $this->data['generated_at']->format('d/m/Y H:i')];
        $rows[] = [''];
        
        // Filter info
        $filterInfo = 'Filter: ';
        if ($this->data['period']['start']) {
            $filterInfo .= 'Periode ' . \Carbon\Carbon::parse($this->data['period']['start'])->format('d/m/Y');
            if ($this->data['period']['end']) {
                $filterInfo .= ' s.d. ' . \Carbon\Carbon::parse($this->data['period']['end'])->format('d/m/Y');
            }
        }
        if ($this->data['year']) {
            $filterInfo .= ' | Tahun: ' . $this->data['year'];
        }
        $rows[] = [$filterInfo];
        $rows[] = [''];
        
        // Ringkasan Statistik
        $rows[] = ['RINGKASAN STATISTIK'];
        $rows[] = ['Total Dokumen', $this->data['total_documents']];
        $rows[] = ['Dipublikasikan', $this->data['published_documents']];
        $rows[] = ['Belum Dipublikasi', $this->data['unpublished_documents']];
        $rows[] = ['Diarsipkan', $this->data['archived_documents']];
        $rows[] = ['Total Unduhan', $this->data['total_downloads']];
        $rows[] = [''];
        
        // Klasifikasi Informasi
        $rows[] = ['KLASIFIKASI INFORMASI'];
        $rows[] = ['Klasifikasi', 'Jumlah', 'Persentase'];
        $rows[] = ['Informasi Terbuka (Open)', $this->data['open_documents'], 
            $this->data['total_documents'] > 0 ? round(($this->data['open_documents'] / $this->data['total_documents']) * 100, 2) . '%' : '0%'];
        $rows[] = ['Informasi Dikecualikan (Excluded)', $this->data['excluded_documents'],
            $this->data['total_documents'] > 0 ? round(($this->data['excluded_documents'] / $this->data['total_documents']) * 100, 2) . '%' : '0%'];
        $rows[] = [''];
        
        // Statistik per Kategori Utama
        $rows[] = ['STATISTIK PER KATEGORI UTAMA'];
        $rows[] = ['Kategori', 'Jumlah', 'Persentase'];
        foreach ($this->data['category_stats'] as $stat) {
            $rows[] = [
                $stat->name,
                $stat->total,
                $this->data['total_documents'] > 0 ? round(($stat->total / $this->data['total_documents']) * 100, 2) . '%' : '0%'
            ];
        }
        $rows[] = [''];
        
        // Tren Bulanan
        $rows[] = ['TREN PUBLIKASI & UNDUHAN PER BULAN'];
        $rows[] = ['Bulan', 'Jumlah Publikasi', 'Jumlah Unduhan'];
        foreach ($this->data['monthly_stats'] as $stat) {
            $rows[] = [
                \Carbon\Carbon::createFromFormat('Y-m', $stat->month)->format('F Y'),
                $stat->total,
                $stat->downloads
            ];
        }
        $rows[] = [''];
        
        // Top 10 Dokumen
        $rows[] = ['10 DOKUMEN PALING BANYAK DIUNDUH'];
        $rows[] = ['No', 'Judul Dokumen', 'Jumlah Unduhan', 'Tanggal Upload'];
        foreach ($this->data['top_documents'] as $index => $doc) {
            $rows[] = [
                $index + 1,
                $doc->title,
                $doc->download_count,
                \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y')
            ];
        }
        
        return $rows;
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            3 => ['font' => ['bold' => true]],
            7 => ['font' => ['bold' => true]],
            8 => ['font' => ['bold' => true]],
            17 => ['font' => ['bold' => true]],
            18 => ['font' => ['bold' => true]],
            25 => ['font' => ['bold' => true]],
            26 => ['font' => ['bold' => true]],
            33 => ['font' => ['bold' => true]],
            34 => ['font' => ['bold' => true]],
        ];
    }
}