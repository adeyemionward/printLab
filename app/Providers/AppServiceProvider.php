<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('*', function ($view) {
            // Calculate remaining days or retrieve from database
            $subdomain = explode('.', request()->getHost())[0];
            $company_details = Company::where('subdomain', $subdomain)->first();

            // Convert the database values to Carbon instances
            //$start_date = Carbon::parse($company_details->sub_start_date);


            if ($company_details && $company_details->sub_start_date) {
                $start_date = $company_details ? Carbon::parse($company_details->sub_start_date) : null;
                $end_date = $company_details ? Carbon::parse($company_details->sub_end_date) : null;
                // Calculate difference in days
                $remaining_days = $start_date->diffInDays($end_date);
            } else {
                // Handle the case when $company_details or $company_details->sub_start_date is null
                // You can provide a default value or handle the null case gracefully
                $remaining_days = null;
            }

           // $end_date = Carbon::parse($company_details->sub_end_date);

            // Calculate the difference
             //$remaining_days = $start_date->diffInDays($end_date);

            // Pass the $remaining_days variable to all views
            $view->with('remaining_days', $remaining_days);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
