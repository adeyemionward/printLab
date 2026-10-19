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
    // public function index(Request $request)
    // {

    //     $all_orders         =   JobOrder::where('company_id', app('company_id'))->whereYear('created_at', Carbon::now()->year)->count();
    //     $pending_orders     =   JobOrder::where('status','Pending')->where('company_id', app('company_id'))->whereYear('created_at', Carbon::now()->year)->count();
    //     $delivered_orders   =   JobOrder::where('status','Delivered')->where('company_id', app('company_id'))->whereYear('created_at', Carbon::now()->year)->count();
    //     $total_cost         =   JobOrder::where('company_id', app('company_id'))->where('cart_order_status', 2)->whereYear('created_at', Carbon::now()->year)->sum('total_cost');
    //     $top_job_orders     =   JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
    //                             ->groupBy('job_order_name')
    //                             ->orderByDesc('total_orders')
    //                             ->where('company_id', app('company_id'))
    //                             ->whereYear('created_at', Carbon::now()->year)
    //                             ->get();

    //     $today   =   Carbon::now()->format('Y-m-d');
    //    // $today    =   Carbon::parse($today1);


    //     $from   =   $request->input('date_from');
    //     $to     =   $request->input('date_to');

    //     $today_orders  = JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
    //     ->groupBy('job_order_name')
    //     ->orderByDesc('total_orders')
    //     ->where('order_date', $today)
    //     ->where('company_id', app('company_id'))
    //     ->get();
    //     //dd($today_orders);

    //     $previous_orders =  JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
    //     ->groupBy('job_order_name')
    //     ->orderByDesc('total_orders')
    //     ->whereBetween('order_date', [$from, $to])
    //     ->where('company_id', app('company_id'))
    //     ->get();


    //     $commissions = DB::table('marketer_commissions as mc')
    //         ->join('users as u', 'mc.marketer_id', '=', 'u.id')
    //         ->join('job_orders as jo', 'mc.job_order_id', '=', 'jo.id')
    //         ->select(
    //             'mc.marketer_id',
    //             'u.firstname',
    //             'u.lastname',
    //             DB::raw('SUM((mc.percentage / 100) * jo.total_cost) as total_commission')
    //         )
    //         ->groupBy('mc.marketer_id', 'u.firstname', 'u.lastname')
    //         ->orderByDesc('total_commission') // Optional: sort by highest performing
    //         ->where('mc.company_id', app('company_id'))
    //         ->get();

    //         $topCompanies = DB::table('job_order_uniques as jou')
    //         ->join('users as u', 'jou.user_id', '=', 'u.id')
    //         ->select(
    //             'u.firstname',
    //             'u.lastname',
    //             DB::raw('SUM(jou.total_cost) as total_spent')
    //         )
    //         ->groupBy('jou.user_id', 'u.firstname', 'u.lastname')
    //         ->orderByDesc('total_spent')
    //         ->limit(5)
    //         ->get();

    //         // dd($topCompanies);


    //     return view('company.dashboard', compact('all_orders','pending_orders','delivered_orders','total_cost','top_job_orders','today_orders','previous_orders','commissions','topCompanies'));
    // }

    public function index(Request $request)
{
    $companyId = app('company_id');
    $currentYear = Carbon::now()->year;

    // Check if custom date range filters are provided
    $fromDate = $request->input('date_from');
    $toDate = $request->input('date_to');

    // 1. Metric Cards Queries (Filtered by custom date range if present, else current year)
    $ordersQuery = JobOrder::where('company_id', $companyId);
    $pendingQuery = JobOrder::where('status', 'Pending')->where('company_id', $companyId);
    $deliveredQuery = JobOrder::where('status', 'Delivered')->where('company_id', $companyId);
    $revenueQuery = JobOrder::where('company_id', $companyId)->where('cart_order_status', 2);
    $topJobsQuery = JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
        ->groupBy('job_order_name')
        ->orderByDesc('total_orders')
        ->where('company_id', $companyId);

    $topCompaniesQuery = DB::table('job_order_uniques as jou')
        ->join('users as u', 'jou.user_id', '=', 'u.id')
        ->select(
            'u.firstname',
            'u.lastname',
            DB::raw('SUM(jou.total_cost) as total_spent')
        )
        ->where('jou.company_id', $companyId)
        ->groupBy('jou.user_id', 'u.firstname', 'u.lastname')
        ->orderByDesc('total_spent')
        ->limit(10);

    if ($fromDate && $toDate) {
        $ordersQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $pendingQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $deliveredQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $revenueQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $topJobsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $topCompaniesQuery->whereBetween('jou.created_at', [$fromDate, $toDate]);
    } else {
        $ordersQuery->whereYear('created_at', $currentYear);
        $pendingQuery->whereYear('created_at', $currentYear);
        $deliveredQuery->whereYear('created_at', $currentYear);
        $revenueQuery->whereYear('created_at', $currentYear);
        $topJobsQuery->whereYear('created_at', $currentYear);
        $topCompaniesQuery->whereYear('jou.created_at', $currentYear);
    }

    $all_orders       = $ordersQuery->count();
    $pending_orders   = $pendingQuery->count();
    $delivered_orders = $deliveredQuery->count();
    $total_cost       = $revenueQuery->sum('total_cost');
    $top_job_orders   = $topJobsQuery->get();
    $topCompanies     = $topCompaniesQuery->get();

    // Today & Previous orders filters (keeping your existing logic)
    $today = Carbon::now()->format('Y-m-d');
    $today_orders = JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
        ->groupBy('job_order_name')
        ->orderByDesc('total_orders')
        ->where('order_date', $today)
        ->where('company_id', $companyId)
        ->get();

    $previous_orders = JobOrder::select('job_order_name', DB::raw('SUM(quantity) as total_orders'))
        ->groupBy('job_order_name')
        ->orderByDesc('total_orders')
        ->whereBetween('order_date', [$fromDate ?? $today, $toDate ?? $today])
        ->where('company_id', $companyId)
        ->get();

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
        ->orderByDesc('total_commission')
        ->where('mc.company_id', $companyId)
        ->get();

    // 2. Dynamic Monthly Revenue vs Expenditure (Adapts to selected date range or current year)
    $revMonthlyQuery = JobOrder::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_cost) as total')
        )
        ->where('company_id', $companyId)
        ->where('cart_order_status', 2);

    $expMonthlyQuery = DB::table('expense_payment_histories')
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount_paid) as total')
        )
        ->where('company_id', $companyId);

    if ($fromDate && $toDate) {
        $revMonthlyQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $expMonthlyQuery->whereBetween('created_at', [$fromDate, $toDate]);
    } else {
        $revMonthlyQuery->whereYear('created_at', $currentYear);
        $expMonthlyQuery->whereYear('created_at', $currentYear);
    }

    $monthlyRevenue = $revMonthlyQuery->groupBy(DB::raw('MONTH(created_at)'))->pluck('total', 'month');
    $monthlyExpenses = $expMonthlyQuery->groupBy(DB::raw('MONTH(created_at)'))->pluck('total', 'month');

    return view('company.dashboard', compact(
        'all_orders','pending_orders','delivered_orders','total_cost',
        'top_job_orders','today_orders','previous_orders','commissions',
        'topCompanies', 'monthlyRevenue', 'monthlyExpenses'
    ));
}
}
