<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
class ViewExpirationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Define the view composer
        View::composer('*', function ($view) {
            // Calculate remaining days or retrieve from database
            $subdomain = explode('.', request()->getHost())[0];
            $company_details = Company::where('subdomain', $subdomain)->first();

            // Convert the database values to Carbon instances
            $start_date = Carbon::parse($company_details->sub_start_date);
            $end_date = Carbon::parse($company_details->sub_end_date);

            // Calculate the difference
             $remaining_days = $start_date->diffInDays($end_date);

            // Pass the $remaining_days variable to all views
            $view->with('remaining_days', $remaining_days);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
