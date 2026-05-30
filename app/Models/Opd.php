<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'logo',
        'address',
        'phone',
        'email',
        'social_media',     // <-- TAMBAHKAN
        'ppid_name',
        'ppid_phone',
        'google_maps_link',
        'is_active',
        
        // CMS Profil OPD
        'tentang_content',
        'tusi_content',
        'tusi_pdf',
        'structure_content',
        'structure_pdf',
        'dasar_hukum_content',
        'dasar_hukum_pdf',
    ];

    protected $casts = [
        'social_media' => 'array',  // <-- TAMBAHKAN
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get social media links as array
     */
    public function getSocialMediaLinks()
    {
        return $this->social_media ?? [];
    }

    public function services()
    {
        return $this->hasMany(OpdService::class)->orderBy('sort_order');
    }

    public function getActiveServices()
    {
        return $this->services()->where('is_active', true)->orderBy('sort_order')->get();
    }
}