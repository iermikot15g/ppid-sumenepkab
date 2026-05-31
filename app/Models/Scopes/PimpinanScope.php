<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class PimpinanScope implements Scope
{
    /**
     * Terapkan scope ini hanya untuk user dengan role pimpinan.
     * Scope ini akan otomatis memfilter query berdasarkan opd_id user.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user();
        
        // Hanya terapkan jika user login, memiliki role pimpinan, dan memiliki opd_id
        if ($user && $user->hasRole('pimpinan') && $user->opd_id) {
            $builder->where('opd_id', $user->opd_id);
        }
    }
}