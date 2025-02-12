<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\UserCity;
use App\Policies\UserCityPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        UserCity::class => UserCityPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
