<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use App\Models\JobPaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\FilterOrdersByDateTrait;
class TransactionController extends Controller
{
    use FilterOrdersByDateTrait;
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:transaction-list', ['only' => ['index']]);

    }

    public function index(Request $request)
    {

        // $startDate  = request('date_from');
        // $endDate    = request('date_to');

        // if(request()->date_to && request()->date_from){
        //     $job_order_pay  = JobPaymentHistory::whereBetween('payment_date', [$startDate, $endDate])->where('company_id', app('company_id'))->get();
        // }else{
        //     $job_order_pay  = JobPaymentHistory::where('company_id', app('company_id'))->get();

        // }

        $startDate  = request('date_from');
        $endDate    = request('date_to');
        $customer   = request('customer');
      //  dd(app('company_id'));
       if(request()->has('customer')) {
            $job_order_pay = $this->filterJobPaymentHistoryByDate()->where('company_id', app('company_id'))->get();
        }else{
            $job_order_pay  = JobPaymentHistory::where('company_id', app('company_id'))->get();
        }

        return view('company.finance.transactions.all_transactions', compact('job_order_pay'));
    }
}
