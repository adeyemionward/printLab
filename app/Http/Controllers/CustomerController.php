<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ErrorLog;
use App\Models\JobOrder;
use App\Models\JobPaymentHistory;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = Customer::all();

        return view('customers.all_customers', compact('customers'));
    }

    public function customer_job_orders($id)
    {
        $customer = Customer::find($id);
        $job_orders =  JobOrder::where('customer_id', $id)->get();

        return view('customers.customer_job_orders', compact('customer','job_orders'));
    }

    public function transaction_history($id){
        $customer = Customer::find($id);
        $job_pay_history =  JobPaymentHistory::where('customer_id',$id)->get();
        return view('customers.transaction_history', compact('customer','job_pay_history'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.add_customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            // 'email' => 'stemaring',
            'phone' => 'required|string',
            'address' => 'required|string',
            // Add more rules as needed
        ], [
            'firstname.required' => 'Please enter customer firstname.',
            'lastname.required' => 'Please enter customer lastname.',
            // 'email.required' => 'Please enter customer email address.',
            // 'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter customer phone number.',
            'address.required' => 'Please enter customer address.',
        ]);

        try{
            $customer = new Customer();
            $customer->firstname    = request('firstname');
            $customer->lastname     = request('lastname');
            $customer->email        = request('email');
            $customer->phone        = request('phone');
            $customer->address      = request('address');

            $customer->save();
            return back()->with("flash_success","Customer saved successfully");

        }catch (\Throwable $th){
            ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return view('customers.view_customer', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('customers.edit_customer', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'phone'     => 'required|string',
            'address'   => 'required|string',
        ], [
            'firstname.required' => 'Please enter customer firstname.',
            'lastname.required' => 'Please enter customer lastname.',
            // 'email.required' => 'Please enter customer email address.',
            // 'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter customer phone number.',
            'address.required' => 'Please enter customer address.',
        ]);
        try{
            $customer = Customer::find($id);
            $customer->firstname    = request('firstname');
            $customer->lastname     = request('lastname');
            $customer->email        = request('email');
            $customer->phone        = request('phone');
            $customer->address      = request('address');

            $customer->update();
            return back()->with("flash_success","Customer saved successfully");

        }catch (\Throwable $th){
            ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id)->delete();
        return redirect(route('customers.all_customers'))->with('flash_success','Customer has been deleted');
    }
}
