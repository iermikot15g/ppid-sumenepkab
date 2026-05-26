<?php
// app/Models/LegalDocument.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'opd_id',
        'title',
        'description',
        'file_path',
        'file_size',
        'regulation_number',
        'year',
        'is_published',
        'download_count',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'year' => 'integer',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}