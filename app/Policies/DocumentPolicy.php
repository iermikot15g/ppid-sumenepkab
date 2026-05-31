<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any documents (index/list).
     * Untuk role pimpinan, hanya bisa melihat dokumen milik OPD-nya sendiri.
     */
    public function viewAny(User $user): bool
    {
        // Super admin dan PPID Utama bisa melihat semua dokumen
        if ($user->hasRole('super_admin') || $user->hasRole('ppid_utama')) {
            return true;
        }

        // PPID Pembantu bisa melihat dokumen OPD-nya sendiri (untuk keperluan edit)
        if ($user->hasRole('ppid_pembantu') && $user->opd_id) {
            return true;
        }

        // Pimpinan bisa melihat dokumen (read-only) tetapi hanya milik OPD-nya
        if ($user->hasRole('pimpinan') && $user->opd_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view a specific document.
     * Pimpinan hanya bisa melihat dokumen milik OPD-nya sendiri.
     */
    public function view(User $user, Document $document): bool
    {
        // Super admin dan PPID Utama bisa melihat semua dokumen
        if ($user->hasRole('super_admin') || $user->hasRole('ppid_utama')) {
            return true;
        }

        // PPID Pembantu hanya bisa melihat dokumen OPD-nya sendiri
        if ($user->hasRole('ppid_pembantu') && $user->opd_id === $document->opd_id) {
            return true;
        }

        // Pimpinan hanya bisa melihat dokumen OPD-nya sendiri (read-only)
        if ($user->hasRole('pimpinan') && $user->opd_id === $document->opd_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create documents.
     * Pimpinan TIDAK BISA membuat dokumen.
     */
    public function create(User $user): bool
    {
        // Pimpinan tidak boleh membuat dokumen
        if ($user->hasRole('pimpinan')) {
            return false;
        }

        // Hanya PPID Pembantu yang boleh membuat dokumen
        return $user->hasRole('ppid_pembantu') || 
               $user->hasRole('super_admin') || 
               $user->hasRole('ppid_utama');
    }

    /**
     * Determine whether the user can update a document.
     * Pimpinan TIDAK BISA mengupdate dokumen.
     */
    public function update(User $user, Document $document): bool
    {
        // Pimpinan tidak boleh mengupdate dokumen
        if ($user->hasRole('pimpinan')) {
            return false;
        }

        // PPID Pembantu hanya bisa mengupdate dokumen OPD-nya sendiri
        if ($user->hasRole('ppid_pembantu') && $user->opd_id === $document->opd_id) {
            return true;
        }

        // Super admin dan PPID Utama bisa mengupdate semua dokumen
        return $user->hasRole('super_admin') || $user->hasRole('ppid_utama');
    }

    /**
     * Determine whether the user can delete a document.
     * Pimpinan TIDAK BISA menghapus dokumen.
     */
    public function delete(User $user, Document $document): bool
    {
        // Pimpinan tidak boleh menghapus dokumen
        if ($user->hasRole('pimpinan')) {
            return false;
        }

        // PPID Pembantu hanya bisa menghapus dokumen OPD-nya sendiri
        if ($user->hasRole('ppid_pembantu') && $user->opd_id === $document->opd_id) {
            return true;
        }

        // Super admin dan PPID Utama bisa menghapus semua dokumen
        return $user->hasRole('super_admin') || $user->hasRole('ppid_utama');
    }

    /**
     * Determine whether the user can publish/unpublish a document.
     * Pimpinan TIDAK BISA mengubah status dokumen.
     */
    public function changeStatus(User $user, Document $document): bool
    {
        // Pimpinan tidak boleh mengubah status
        if ($user->hasRole('pimpinan')) {
            return false;
        }

        // PPID Pembantu hanya bisa mengubah status dokumen OPD-nya sendiri
        if ($user->hasRole('ppid_pembantu') && $user->opd_id === $document->opd_id) {
            return true;
        }

        // Super admin dan PPID Utama bisa mengubah status semua dokumen
        return $user->hasRole('super_admin') || $user->hasRole('ppid_utama');
    }
}