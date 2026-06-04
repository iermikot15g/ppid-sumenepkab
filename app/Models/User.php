<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'opd_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'created_by');
    }

    public function isPpidPembantu()
    {
        return $this->hasRole('ppid_pembantu') && $this->opd_id;
    }

    public function canManageOpd($opdId)
    {
        if ($this->hasRole('super_admin') || $this->hasRole('ppid_utama')) {
            return true;
        }
        
        return $this->hasRole('ppid_pembantu') && $this->opd_id == $opdId;
    }

    // Tambahkan relasi
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
}