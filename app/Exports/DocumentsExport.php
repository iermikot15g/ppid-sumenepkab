<?php
// app/Exports/DocumentsExport.php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DocumentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $documents;

    public function __construct($documents)
    {
        $this->documents = $documents;
    }

    public function collection()
    {
        return $this->documents;
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul Dokumen',
            'OPD',
            'Kategori',
            'Tahun',
            'Nomor Dokumen',
            'Klasifikasi',
            'Status',
            'Jumlah Unduh',
            'Tanggal Upload',
        ];
    }

    public function map($document): array
    {
        static $row = 0;
        $row++;
        
        return [
            $row,
            $document->title,
            $document->opd->name ?? '-',
            $document->category->name ?? '-',
            $document->year,
            $document->doc_number ?? '-',
            $document->classification === 'open' ? 'Terbuka' : 'Dikecualikan',
            ucfirst($document->status),
            $document->download_count,
            $document->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}