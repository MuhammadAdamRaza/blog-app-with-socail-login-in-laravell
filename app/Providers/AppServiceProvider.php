<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define(
            'reports.view',
            fn(User $user) =>
            $user->hasPermissionTo('reports.view')
        );

        Gate::define(
            'settings.manage',
            fn(User $user) =>
            $user->hasPermissionTo('settings.manage')
        );

        Gate::define(
            'roles.manage',
            fn(User $user) =>
            $user->hasPermissionTo('roles.manage')
        );

        Gate::define(
            'permissions.manage',
            fn(User $user) =>
            $user->hasPermissionTo('permissions.manage')
        );

        Gate::define(
            'roles.assign',
            fn(User $user) =>
            $user->hasPermissionTo('roles.assign')
        );

        Gate::define(
            'users.delete',
            fn(User $user) =>
            $user->hasPermissionTo('users.delete')
        );

        Gate::define(
            'posts.assign',
            fn(User $user) =>
            $user->hasPermissionTo('posts.assign')
        );

        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite(
                'linkedin',
                \SocialiteProviders\LinkedIn\Provider::class
            );
        });
    }
}
