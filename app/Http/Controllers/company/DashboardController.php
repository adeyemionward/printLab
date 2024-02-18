<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Models\JobOrder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        $all_orders         =   JobOrder::count();
        $pending_orders     =   JobOrder::where('status','Pending')->count();
        $delivered_orders   =   JobOrder::where('status','Delivered')->count();
        $total_cost         =   JobOrder::sum('total_cost');
        $top_job_orders     =   JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
                                ->groupBy('job_order_name')
                                ->orderByDesc('total_orders')
                                ->get();




        $today   =   Carbon::now()->format('Y-m-d');
       // $today    =   Carbon::parse($today1);


        $from   =   $request->input('date_from');
        $to     =   $request->input('date_to');

        $today_orders  = JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
        ->groupBy('job_order_name')
        ->orderByDesc('total_orders')
        ->where('order_date', $today)
        ->get();
        //dd($today_orders);

        $previous_orders =  JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
        ->groupBy('job_order_name')
        ->orderByDesc('total_orders')
        ->whereBetween('order_date', [$from, $to])
        ->get();
        return view('dashboard', compact('all_orders','pending_orders','delivered_orders','total_cost','top_job_orders','today_orders','previous_orders'));
    }
}
