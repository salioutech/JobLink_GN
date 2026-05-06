<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Service;
use App\Models\Offre;
use App\Policies\ServicePolicy;
use App\Policies\OffrePolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Service::class => ServicePolicy::class,
        Offre::class   => OffrePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}