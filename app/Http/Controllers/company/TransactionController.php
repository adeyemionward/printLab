<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use App\Models\JobPaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware('permission:transaction-list', ['only' => ['index']]);

    }

    public function index(Request $request)
    {

        $startDate  = request('date_from');
        $endDate    = request('date_to');

        if(request()->date_to && request()->date_from){
            $job_order_pay  = JobPaymentHistory::whereBetween('payment_date', [$startDate, $endDate])->get();
        }else{
            $job_order_pay  = JobPaymentHistory::all();

        }
        return view('company.finance.transactions.all_transactions', compact('job_order_pay'));
    }
}
