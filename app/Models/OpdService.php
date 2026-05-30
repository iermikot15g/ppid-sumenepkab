<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OpdService extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_id',
        'name',
        'description',
        'url',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function getFaviconUrl()
    {
        if ($this->icon && Storage::disk('public')->exists($this->icon)) {
            return Storage::url($this->icon);
        }
        
        $domain = parse_url($this->url, PHP_URL_HOST);
        if (!$domain) {
            $domain = str_replace(['http://', 'https://'], '', $this->url);
            $domain = explode('/', $domain)[0];
        }
        
        return 'https://www.google.com/s2/favicons?domain=' . urlencode($domain) . '&sz=64';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForOpd($query, $opdId)
    {
        return $query->where('opd_id', $opdId);
    }
}