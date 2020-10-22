<?php

namespace App\Providers;

use App\Models\Package;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use function React\Promise\all;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('settings', function ($user) {
            return $user->isSuperadmin;
        });

        Gate::define('account', function ($user) {
            return $user->isSuperadmin || $user->isAdmin;
        });

        Gate::define('package', function ($user, Package $package) {
            $allow = $user->isSuperadmin
                ? true
                : $package->location_id === $user->location_id;
            return $allow;
        });

        //
    }
}
