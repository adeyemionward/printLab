<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('*', function ($view) {
            // Calculate remaining days or retrieve from database
            $subdomain = explode('.', request()->getHost())[0];
            $company_details = Company::where('subdomain', $subdomain)->first();
            $today = Carbon::parse(Carbon::today()->toDateString());
           

            if ($company_details && $company_details->sub_start_date) {
                $start_date = $company_details ? Carbon::parse($company_details->sub_start_date) : null;
                $end_date = $company_details ? Carbon::parse($company_details->sub_end_date) : null;
                // Calculate difference in days
                $remaining_days = $today->diffInDays($end_date);
            } else {
                // Handle the case when $company_details or $company_details->sub_start_date is null
                // You can provide a default value or handle the null case gracefully
                $remaining_days = null;
            }
            
            //get the site settings
            $user = Auth::user();
            $site_details = SiteSetting::where('company_id', $user->company_id)->first();

            // Pass the  variables to all views
            $view->with('site_details', $site_details);
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
