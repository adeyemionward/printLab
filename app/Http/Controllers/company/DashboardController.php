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
        $total_cost         =   JobOrder::where('company_id', app('company_id'))->whereYear('created_at', Carbon::now()->year)->sum('total_cost');
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
      

        $commissions = DB::table('marketer_commissions as mc')
            ->join('users as u', 'mc.marketer_id', '=', 'u.id')
            ->join('job_orders as jo', 'mc.job_order_id', '=', 'jo.id')
            ->select(
                'mc.marketer_id',
                'u.firstname',
                'u.lastname',
                DB::raw('SUM((mc.percentage / 100) * jo.total_cost) as total_commission')
            )
            ->groupBy('mc.marketer_id', 'u.firstname', 'u.lastname')
            ->orderByDesc('total_commission') // Optional: sort by highest performing
            ->where('mc.company_id', app('company_id'))
            ->get();

            $topCompanies = DB::table('job_order_uniques as jou')
            ->join('users as u', 'jou.user_id', '=', 'u.id')
            ->select(
                'u.firstname',
                'u.lastname',
                DB::raw('SUM(jou.total_cost) as total_spent')
            )
            ->groupBy('jou.user_id', 'u.firstname', 'u.lastname')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();
          

        return view('company.dashboard', compact('all_orders','pending_orders','delivered_orders','total_cost','top_job_orders','today_orders','previous_orders','commissions','topCompanies'));
    }
}
