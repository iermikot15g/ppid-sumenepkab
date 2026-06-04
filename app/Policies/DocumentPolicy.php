<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;

class DocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_own_opd_documents');
    }
    
    public function view(User $user, Document $document): bool
    {
        if ($user->hasRole(['super_admin', 'ppid_utama'])) {
            return true;
        }
        
        if ($user->hasRole('masyarakat')) {
            return $document->status === 'published';
        }
        
        if ($user->hasRole('pimpinan')) {
            return $user->opd_id === $document->opd_id;
        }
        
        if ($user->hasRole('ppid_pembantu')) {
            return $user->opd_id === $document->opd_id && $user->hasPermissionTo('view_own_opd_documents');
        }
        
        return false;
    }
    
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_own_opd_documents');
    }
    
    public function update(User $user, Document $document): bool
    {
        if ($user->hasRole('ppid_pembantu')) {
            return $user->opd_id === $document->opd_id && $user->hasPermissionTo('manage_own_opd_documents');
        }
        
        if ($user->hasRole(['super_admin', 'ppid_utama'])) {
            return true;
        }
        
        return false;
    }
    
    public function delete(User $user, Document $document): bool
    {
        if ($user->hasRole('ppid_pembantu')) {
            return $user->opd_id === $document->opd_id && $user->hasPermissionTo('manage_own_opd_documents');
        }
        
        return $user->hasRole(['super_admin', 'ppid_utama']);
    }
    
    public function download(User $user, Document $document): bool
    {
        return $user->hasPermissionTo('download_document') && $document->status === 'published';
    }
}