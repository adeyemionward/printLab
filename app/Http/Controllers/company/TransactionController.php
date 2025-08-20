<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use App\Models\JobOrder;
use App\Models\JobPaymentNewHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\FilterOrdersByDateTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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


        $startDate  = request('date_from');
        $endDate    = request('date_to');
        $customer   = request('customer');
      //  dd(app('company_id'));
        if(request()->has('customer')) {
            $job_order_pay = $this->filterJobPaymentHistoryByDate()->where('company_id', app('company_id'))->get();
        }else{
            $job_order_pay  = JobPaymentNewHistory::where('company_id', app('company_id'))->whereYear('created_at', Carbon::now()->year)->latest()->get();
        }

        return view('company.finance.transactions.all_transactions', compact('job_order_pay'));
    }

    public function addCustomerJobPayment(){
        $job_orders = JobOrder::where('cart_order_status', 2)
        ->where('company_id', app('company_id'))
        ->select('id', 'job_order_name', 'order_no')
        ->get();


        return view('company.finance.transactions.add_transaction', compact('job_orders'));
    }


    // public function getJobOrders($customerId)
    // {
    //     $job_orders = JobOrder::where('cart_order_status', 2)
    //     ->where('user_id', $customerId)
    //     ->where('company_id', app('company_id'))
    //     ->distinct()
    //     ->pluck('order_no');

    //     return response()->json($job_orders);

    // }

    public function getJobOrders($customerId)
{
    // $job_orders = JobOrder::where('cart_order_status', 2)
    //     ->where('user_id', $customerId)
    //     ->where('company_id', app('company_id'))
    //     // Use get() to select specific columns as an object
    //     ->get(['id', 'order_no']);

    // return response()->json($job_orders);

    // Step 1: Fetch the initial job orders, making sure to include 'total_cost'.
    $job_orders = JobOrder::where('cart_order_status', 2)
        ->where('user_id', $customerId)
        ->where('company_id', app('company_id'))
        ->get(['id', 'order_no', 'total_cost','job_order_name']);

    // Step 2: Use the 'map' function to transform each job order object.
    $job_orders_with_status = $job_orders->map(function ($job_order) {
        
        // Step 3: For each job order, calculate the sum of payments made.
        $totalPaid = JobPaymentNewHistory::where('order_no', $job_order->order_no)
                                         ->sum('amount');

        // Step 4: Calculate the remaining balance and determine the payment status.
        $balance = $job_order->total_cost - $totalPaid;
        $status = 'Unpaid'; // Default status

        if ($totalPaid >= $job_order->total_cost) {
            $status = 'Fully Paid';
            $balance = 0; // Ensure balance doesn't show negative if overpaid
        } elseif ($totalPaid > 0) {
            $status = 'Partially Paid';
        }

        // Step 5: Create the formatted string for the dropdown display.
        $formattedBalance = number_format($balance, 2);
        $displayText = "#{$job_order->order_no} - {$job_order->job_order_name} (Balance: {$formattedBalance} - {$status})";

        // Step 6: Return a new object with the ID and the new display text.
        return [
            'id' => $job_order->id,
            'displayText' => $displayText,
        ];
    });

    // Step 7: Return the newly created collection as JSON.
    return response()->json($job_orders_with_status);

}

    public function storeCustomerJobPayment1(Request $request){
        try{
            $user = Auth::user();
            $order_date = date('Y-m-d');
            $order_id                   =  request('order_id');
            $amount_paid                =  request('amount_paid');
            $payment_type               =  request('payment_type');

            $job_order =  JobOrder::where('order_no',$order_id)->first();
            // dd($job_order);
            $job_pay = new JobPaymentNewHistory();
            $job_pay->company_id      = app('company_id');
            $job_pay->job_order_unique_id    = $job_order->job_order_unique_id;
            $job_pay->order_no        = $order_id;
            $job_pay->user_id         = $job_order->user_id;
            $job_pay->amount          = str_replace(',', '',$amount_paid);
            $job_pay->payment_type    = $payment_type;
            $job_pay->payment_date    = $order_date;
            $job_pay->created_by      = $user->id;
            $job_pay->save();
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }


        return back()->with("flash_success","Order Payment updated successfully");
    }


    public function storeCustomerJobPayment(Request $request)
{
    // 1. VALIDATE THE INCOMING DATA
    // The '*' wildcard validates every element in the submitted arrays.
    $request->validate([
        'customer_id'   => 'required|numeric|exists:users,id',
        'order_id'      => 'required|array|min:1',
        'order_id.*'    => 'required|numeric|exists:job_orders,id',
        'payment_type'  => 'required|array',
        'payment_type.*'=> 'required|string',
        'amount_paid'   => 'required|array',
        'amount_paid.*' => 'required|string', // Validated as string because of commas
    ]);

    // Use a database transaction to ensure all payments are saved or none are.
    DB::beginTransaction();

    try {
        $user = Auth::user();
        $payment_date = now()->toDateString(); // More reliable way to get date

        // 2. LOOP THROUGH EACH SUBMITTED PAYMENT ROW
        foreach ($request->order_id as $key => $orderId) {
            
            // Find the original JobOrder using the ID from the form
            $job_order = JobOrder::find($orderId);

            // Skip if for some reason the job order isn't found
            if (!$job_order) {
                continue;
            }

            // 3. CREATE AND SAVE A NEW PAYMENT RECORD FOR EACH ROW
            $job_pay = new JobPaymentNewHistory();
            $job_pay->company_id          = app('company_id');
            $job_pay->job_order_unique_id = $job_order->job_order_unique_id;
            $job_pay->order_no            = $job_order->order_no;
            $job_pay->user_id             = $job_order->user_id; // Or $request->customer_id
            
            // Get the amount_paid corresponding to this loop iteration
            $amount_paid = $request->amount_paid[$key];
            $job_pay->amount              = str_replace(',', '', $amount_paid);
            
            // Get the payment_type for this loop iteration
            $job_pay->payment_type        = $request->payment_type[$key];
            
            $job_pay->payment_date        = $payment_date;
            $job_pay->created_by          = $user->id;
            $job_pay->save();
        }

        // If the loop completes without errors, commit the transaction
        DB::commit();

    } catch (\Exception $th) {
        // If any error occurs, roll back all database changes
        DB::rollBack();
        // You can also log the error for debugging: \Log::error($th);
        return redirect()->back()->with('flash_error', 'An Error Occurred: Please try later');
    }

    return redirect()->back()->with('flash_success', 'Order Payments have been saved successfully');
}

}
