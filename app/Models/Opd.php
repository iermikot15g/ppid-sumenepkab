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
        'social_media',
        'ppid_name',
        'ppid_phone',
        'vision_mission',
        'duties',
        'is_active',
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

    public function getActiveDocumentsCount()
    {
        return $this->documents()->where('status', 'published')->count();
    }

    public function getLastUpdateDate()
    {
        return $this->documents()->max('updated_at');
    }
}