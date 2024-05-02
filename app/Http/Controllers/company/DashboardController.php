<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        $all_orders         =   JobOrder::where('company_id', app('company_id'))->count();
        $pending_orders     =   JobOrder::where('status','Pending')->where('company_id', app('company_id'))->count();
        $delivered_orders   =   JobOrder::where('status','Delivered')->where('company_id', app('company_id'))->count();
        $total_cost         =   JobOrder::where('company_id', app('company_id'))->sum('total_cost');
        $top_job_orders     =   JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
                                ->groupBy('job_order_name')
                                ->orderByDesc('total_orders')
                                ->where('company_id', app('company_id'))
                                ->get();




        $today   =   Carbon::now()->format('Y-m-d');
       // $today    =   Carbon::parse($today1);


        $from   =   $request->input('date_from');
        $to     =   $request->input('date_to');

        $today_orders  = JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
        ->groupBy('job_order_name')
        ->orderByDesc('total_orders')
        ->where('order_date', $today)
        ->where('company_id', app('company_id'))
        ->get();
        //dd($today_orders);

        $previous_orders =  JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
        ->groupBy('job_order_name')
        ->orderByDesc('total_orders')
        ->whereBetween('order_date', [$from, $to])
        ->where('company_id', app('company_id'))
        ->get();

       // return $today = Carbon::parse(Carbon::today()->toDateString());

        return view('company.dashboard', compact('all_orders','pending_orders','delivered_orders','total_cost','top_job_orders','today_orders','previous_orders'));
    }
}
