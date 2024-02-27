<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Carbon\Carbon;



class SubscriptionController extends Controller
{
    
    protected $today;
    
    public function __construct()
    {
        // Get today's date
        $this->today = Carbon::today()->toDateString();
    }

    public function activeSubcription()
    {
        $subscriptions = Subscription::where('sub_end_date', '>=', $this->today)->get();
    }

    public function inactiveSubcription()
    {
        $subscriptions = Subscription::where('sub_end_date', '<', $this->today)->get();
    }

}