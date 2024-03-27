<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Company;
use App\Repository\SubscriptionRepository;
use Carbon\Carbon;



class SubscriptionController extends Controller
{
    
    protected $today;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->middleware('auth');

        // Get today's date
        $this->today = Carbon::today()->toDateString();
        $this->middleware('auth');
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function addSubscription()
    {
        $companies =  Company::all();
        $subs  = SubscriptionPlan::all();
        return view('admin.subscriptions.add', compact('companies','subs'));
    } 

    public function storeSubscription(Request $request)
    {
        return $response = $this->subscriptionRepository->postSubscription($request);
    }

    public function activeSubscription() 
    {
        $active_subscriptions = Subscription::where('sub_end_date', '>=', $this->today)->where('status', 'active')->get();
        return view('admin.subscriptions.active', compact('active_subscriptions'));
    }

    public function inactiveSubscription()
    {
        $inactive_subscriptions = Subscription::where('sub_end_date', '<', $this->today)->get();
        return view('admin.subscriptions.inactive', compact('inactive_subscriptions'));
    }

}