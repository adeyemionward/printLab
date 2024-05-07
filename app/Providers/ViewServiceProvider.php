<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Models\Company;
use App\Models\User;
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

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
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

                $site_details = SiteSetting::where('company_id', $company_details->id)->first();
            } else {
                // Handle the case when $company_details or $company_details->sub_start_date is null
                // You can provide a default value or handle the null case gracefully
                $remaining_days = null;
                $site_details = null;
            }

            //get the site settings
            //$user = Auth::user();
            //if ($user) {

                $view->with('site_details', $site_details);
            //}

            // Pass the  variables to all views

            $view->with('remaining_days', $remaining_days);

            $roles = Role::where('company_id', app('company_id'))->orWhere('name','admin')->get();
            $userId = request()->user_company_id;
            if(!is_null($userId)){
                $user =  User::find($userId);
                $current_roles = @$user->getRoleNames();

                foreach($current_roles as $current_role1){
                    $current_role =  $current_role1;
                }
                $view->with('current_role', $current_role);
            }



            // Pass the  variables to all views

            $view->with('roles', $roles);

        });
    }
}
