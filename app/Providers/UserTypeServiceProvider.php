<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;

class UserTypeServiceProvider extends ServiceProvider
{
    public function boot()
    {

        View::composer('*', function ($view) {
            $members = User::where('user_type', USER::MEMBER)->get();
            $staff = User::where('user_type', USER::STAFF)->get();

            $view->with('members', $members);
            $view->with('staff', $staff);
        });

    }

    public function register()
    {
        //
    }
}
