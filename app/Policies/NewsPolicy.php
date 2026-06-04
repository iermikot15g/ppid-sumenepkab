<?php

namespace App\Policies;

use App\Models\User;
use App\Models\News;

class NewsPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_own_opd_gallery');
    }

    public function view(User $user, News $news): bool
    {
        if ($user->hasRole(['super_admin', 'ppid_utama'])) {
            return true;
        }
        
        return $user->opd_id === $news->opd_id && $user->hasPermissionTo('view_own_opd_gallery');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_own_opd_gallery');
    }

    public function update(User $user, News $news): bool
    {
        if ($user->hasRole(['super_admin', 'ppid_utama'])) {
            return true;
        }
        
        return $user->opd_id === $news->opd_id && $user->hasPermissionTo('manage_own_opd_gallery');
    }

    public function delete(User $user, News $news): bool
    {
        if ($user->hasRole(['super_admin', 'ppid_utama'])) {
            return true;
        }
        
        return $user->opd_id === $news->opd_id && $user->hasPermissionTo('manage_own_opd_gallery');
    }
}