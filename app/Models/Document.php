<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\PimpinanScope; // Tambahkan ini

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'opd_id',
        'category_id',
        'sub_category_id',
        'title',
        'description',
        'doc_number',
        'year',
        'officer_name',
        'classification',
        'status',
        'file_path',
        'file_size',
        'file_mime',
        'download_count',
        'published_at',
        'created_by',
        'last_edited_by',
        'force_unpublished_by',
        'force_unpublished_reason',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'year' => 'integer',
        'file_size' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * Boot method untuk mendaftarkan global scope
     */
    protected static function booted()
    {
        // Hanya aktifkan scope jika tidak dalam konteks console/command
        if (!app()->runningInConsole()) {
            static::addGlobalScope(new PimpinanScope);
        }
    }

    // ... relasi-relasi yang sudah ada tetap sama ...
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lastEditor()
    {
        return $this->belongsTo(User::class, 'last_edited_by');
    }

    public function forceUnpublishedBy()
    {
        return $this->belongsTo(User::class, 'force_unpublished_by');
    }

    public function logs()
    {
        return $this->hasMany(DocumentLog::class);
    }

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    public function isExcluded()
    {
        return $this->classification === 'excluded';
    }

    public function canBeDownloaded()
    {
        return $this->status === 'published' && $this->classification === 'open';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByOpd($query, $opdId)
    {
        return $query->where('opd_id', $opdId);
    }
}