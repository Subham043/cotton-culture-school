<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //custom link for reset password
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return URL::temporarySignedRoute('reset_password', now()->addMinutes(60), ['token' => $token]);
        });
    }
}
