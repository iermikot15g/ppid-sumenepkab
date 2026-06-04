<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Document;
use App\Policies\DocumentPolicy;
use App\Models\News;
use App\Policies\NewsPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Document::class => DocumentPolicy::class,
        News::class => NewsPolicy::class,  // <-- APAKAH INI SUDAH ADA?
    ];
    
    public function boot(): void
    {
        $this->registerPolicies();
        
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super_admin')) {
                return true;
            }
            return null;
        });
    }
}