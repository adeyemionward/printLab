<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    protected $today;
    public function __construct()
    {
        // Get today's date
        $this->today = Carbon::today()->toDateString();
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $date60DaysAgo = Carbon::now()->subDays(60);


        $total_companies                =   Company::count();
        $active_subscribed_companies               =   Company::where('status',Company::ACTIVE)->where('sub_end_date', '>=', $this->today)->get();
        $total_active_companies         =   count($active_subscribed_companies);
        $inactive_companies             =   Company::where('status',Company::INACTIVE)->get();
        $total_inactive_companies       =   count($inactive_companies);
        $new_companies                  =   Company::whereDate('created_at', '>=', $date60DaysAgo)->get();

        $total_revenue = Subscription::where('status', 'active')->sum('sub_amount');



        return view('admin.dashboard', compact('total_companies','active_subscribed_companies','total_active_companies','inactive_companies','total_inactive_companies','total_revenue','new_companies'));
    }
}
