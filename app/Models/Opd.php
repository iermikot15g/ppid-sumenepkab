<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $fillable = [
        // Data dasar OPD
        'name',
        'short_name',
        'logo',
        'address',
        'google_maps_link',
        'phone',
        'email',
        'social_media',
        'ppid_name',
        'ppid_phone',
        'vision_mission',
        'duties',
        'is_active',
        
        // ========== CMS PROFIL OPD ==========
        // Tentang OPD
        'tentang_content',
        'tentang_pdf',  // TAMBAHKAN
        
        // Tugas dan Fungsi
        'tugas_fungsi_content',    // <-- PERBAIKAN: dari 'tusi_content'
        'tugas_fungsi_pdf',        // <-- PERBAIKAN: dari 'tusi_pdf'
        
        // Struktur Organisasi
        'struktur_content',        // <-- PERBAIKAN: dari 'structure_content'
        'struktur_pdf',            // <-- PERBAIKAN: dari 'structure_pdf'
        
        // Dasar Hukum
        'dasar_hukum_content',
        'dasar_hukum_pdf',
    ];

    protected $casts = [
        'social_media' => 'array',
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