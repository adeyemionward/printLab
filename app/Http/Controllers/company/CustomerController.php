<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\ErrorLog;
use App\Models\JobOrder;
use App\Models\JobPaymentHistory;
use Illuminate\Support\Facades\Hash;
use App\Mail\CustomerOrderReceipt;
use App\Models\JobLocation;
use App\Models\JobOrderTracking;
use App\Models\JobOrderUnique;
use App\Models\JobPaymentNewHistory;
use App\Models\MarketerCommission;
use Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\SmallInvoiceRepository;
use App\Repository\StickersRepository;
use App\Repository\NoteBookRepository;
use App\Repository\NotePadRepository;
use App\Repository\BookletRepository;
use App\Repository\FlyerRepository;
use App\Repository\BrochureRepository;
use App\Repository\BusinessCardRepository;
use App\Repository\EnvelopeRepository;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      private $noteBookRepository;
    private $smallInvoiceRepository;
    private $stickersRepository;
    private $notePadRepository;
    private $bookletRepository;
    private $flyerRepository;
    private $brochureRepository;
    private $businessCardRepository;
    private $envelopeRepository;

    public function __construct(
         NoteBookRepository $noteBookRepository,
        SmallInvoiceRepository $smallInvoiceRepository,
        StickersRepository $stickersRepository,
        NotePadRepository $notePadRepository,
        BookletRepository $bookletRepository,
        FlyerRepository $flyerRepository,
        BrochureRepository $brochureRepository,
        BusinessCardRepository $businessCardRepository,
        EnvelopeRepository $envelopeRepository
    )
    {
        
        $this->noteBookRepository = $noteBookRepository;
        $this->smallInvoiceRepository = $smallInvoiceRepository;
        $this->stickersRepository = $stickersRepository;
        $this->notePadRepository = $notePadRepository;
        $this->bookletRepository = $bookletRepository;
        $this->flyerRepository = $flyerRepository;
        $this->brochureRepository = $brochureRepository;
        $this->businessCardRepository = $businessCardRepository;
        $this->envelopeRepository = $envelopeRepository;
        
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user(); return $next($request);
        });

        $this->middleware('auth');

        $this->middleware('permission:customer-create', ['only' => ['create','store']]);

        $this->middleware('permission:customer-list', ['only' => ['index']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);

        $this->middleware('permission:customer-cart', ['only' => ['customer_cart']]);
        $this->middleware('permission:customer-checkout', ['only' => ['checkout']]);
        $this->middleware('permission:customer-job-orders', ['only' => ['customer_job_orders']]);
        $this->middleware('permission:customer-transaction-history', ['only' => ['transaction_history']]);

    }

    private function countCart($user_id){

        $cart_count = JobOrder::where('cart_order_status', 1)->where('user_id',$user_id)->where('company_id',$this->user->company_id)->get();

        $countCart  = count($cart_count);
        return $countCart;
    }

    private function find_customer ($user_id){
       return $customer = User::find($user_id);
    }

    public function index()
    {
        $customers = User::where('user_type', User::CUSTOMER)->where('status','active')->where('company_id',app('company_id'))->get();

        return view('company.customers.all_customers', compact('customers'));
    }

    public function customer_cart($id)
    {
        $customer = $this->find_customer($id);
        $cartCount = $this->countCart($id);
        $job_orders =  JobOrder::where('user_id', $id)->where('company_id',app('company_id'))->where('cart_order_status',1)->get();

        return view('company.customers.customer_cart', compact('customer','job_orders','cartCount'));
    } 

    public function view_cart_order($id, $job_id)
    {
        $job_order = JobOrder::where('id', $job_id)->where('company_id',app('company_id'))->first();
        $customer = $this->find_customer($id);
        $cartCount = $this->countCart($id);
        // $job_orders =  JobOrder::where('id', $id)->where('company_id',app('company_id'))->first();

        return view('company.customers.view_cart_order', compact('customer','job_order','cartCount'));
    }

     public function edit_cart_order($id, $job_id)
    {
        $job_order = JobOrder::where('id', $job_id)->where('company_id',app('company_id'))->first();
        // dd($job_order->job_order_name);
        $customer = $this->find_customer($id);
        $cartCount = $this->countCart($id);

        $customers =  User::getCustomers();
        $locations =  JobLocation::getLocations();
        
        $job_marketers_commission = MarketerCommission::where('job_order_id', $job_id)->get();
        // $job_orders =  JobOrder::where('id', $id)->where('company_id',app('company_id'))->first();

        return view('company.customers.edit_cart_order', compact('customer','customers', 'locations', 'job_marketers_commission', 'job_order','cartCount'));
    }

     public function update_cart_order(Request $request, $id, $job_id){
        $user = Auth::user();
        DB::beginTransaction();
        try{
            $job_order = JobOrder::where('id', $id)->where('company_id',app('company_id'))->first();
          

            if($job_order->job_order_name == 'Eighty Leaves' || $job_order->job_order_name == 'Higher NoteBook' || $job_order->job_order_name == 'Twenty Leaves'|| $job_order->job_order_name == 'Forty Leaves'|| $job_order->job_order_name == 'Sixty Leaves' || $job_order->job_order_name == '2A NoteBook' || $job_order->job_order_name == '2B NoteBook'|| $job_order->job_order_name == '2D NoteBook' || $job_order->job_order_name == 'Drawing Book'){
                $response = $this->noteBookRepository->updateCartNoteBookOrder($request);

            }elseif($job_order->job_order_name == 'Small Invoice'){

                $response = $this->smallInvoiceRepository->updateSmallInvoiceOrder($request);

            }elseif($job_order->job_order_name == 'Brochures'){
                $response = $this->brochureRepository->updateBrochure($request);

            }elseif($job_order->job_order_name == 'Flyer'){
                $response = $this->flyerRepository->updateFlyer($request);

            }elseif($job_order->job_order_name == 'Business Cards'){

                $response = $this->businessCardRepository->updateBusinessCard($request);

            }elseif($job_order->job_order_name == 'Envelopes'){
                $response = $this->envelopeRepository->updateEnvelope($request);

            }elseif($job_order->job_order_name == 'Notepads'){

                $response = $this->notePadRepository->updateNotePadOrder($request);

            }elseif($job_order->job_order_name == 'Stickers'){

                $response = $this->stickersRepository->updateStickersOrder($request);
            }
            DB::commit();
        }catch(\Exception $th){
            DB::rollBack();
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }
        return $response;
    }

    public function delete_cart_order()
    {

        $cartjob = JobOrder::find(request()->job_id);
        // $customer->status = 'deactivated';
        $cartjob->delete();
          return redirect()->back()->with('flash_success','Cart order has been deleted');
    }

    public function checkout($id)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $customer = $this->find_customer($id);
            $order_date = date('Y-m-d');
            $job_id  = request('job_id');
            $randomInteger = random_int(100000, 999999);
            $userDetails    = User::find($id);

            // Calculate the sum of total_cost
            $totalCostSum = JobOrder::whereIn('id', $job_id)
            ->where('company_id', app('company_id'))->sum('total_cost'); //get the som total of the order

            //save to job_order_unique
            $job_order_unique = new JobOrderUnique();
            $job_order_unique->user_id         = $id;
            $job_order_unique->company_id      = $user->company_id;
            $job_order_unique->order_no        = $randomInteger;
            $job_order_unique->order_date      = $order_date;
            $job_order_unique->total_cost      = $totalCostSum;
            $job_order_unique->cart_order_status      = 2; //completed
            $job_order_unique->order_type      = 'internal'; //completed
            $job_order_unique->created_by      = $user->id;
            $job_order_unique->save();

            // JobOrderTracking::saveJobOrderTracking($job_order_unique->id, $order_date);

            $checkout =  JobOrder::whereIn('id', $job_id)->where('company_id',app('company_id'))->update(
                [
                    'cart_order_status' =>  2,
                    'job_order_unique_id' =>  $job_order_unique->id,
                    'order_no' =>  $randomInteger,
                ]
            );

            $userEmail  =  $userDetails->email;
            $userName   =  $userDetails->firstname.' '.$userDetails->lastname;

            $orderDetails   = JobOrder::whereIn('id',$job_id)->where('company_id',app('company_id'))->get();

            $payment_type =  0;
            $amount_paid = 0;
            $data = [
                'payment_type' =>'',
                'amount_paid'  => '',
                'userDetails'  => $userDetails,
                'orderDetails' => $orderDetails, // Collection of orders, for example
            ];
            $pdf_attachment =   Pdf::loadView('front.invoice_attachment', $data );
  
            // try {
            //     Mail::to($userEmail)->send(new CustomerOrderReceipt ($orderDetails,$amount_paid,$userName,$pdf_attachment));
            // } catch (\Exception $emailException) {
            //     // Handle the email exception separately
            //     Log::error('Failed to send order email: ' . $emailException->getMessage());
        
            //     // Optionally inform the user
            //     return redirect(route('company.customers.customer_job_orders', $id))
            //         ->with('flash_error', 'Order processed but email sending failed.');
            // }
            // Try sending the email and handle failure gracefully
            $emailSent = true;
            try {
                Mail::to($userEmail)->send(new CustomerOrderReceipt($orderDetails, $amount_paid, $userName, $pdf_attachment));
            } catch (\Exception $e) {
                Log::error('Failed to send email: ' . $e->getMessage());
                $emailSent = false; // Mark email as not sent
            }

            DB::commit();

            // Redirect with success and email status
            if ($emailSent) {
                return redirect(route('company.customers.customer_job_orders', $id))->with('flash_success', 'Order processed successfully, and email sent!');
            } else {
                return redirect(route('company.customers.customer_job_orders', $id))->with('flash_warning', 'Order processed successfully, but email failed to send.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            Log::error('Failed to send order: ' . $e->getMessage());

            // Optionally, you can set a flash message to notify the user of the issue
            return redirect()->back()->with('flash_error', 'There is an error processing this order');
        }
        // return redirect(route('company.customers.customer_job_orders', $id))->with('flash_success','Product Order Successful');
    }

    public function customer_job_orders($id)
    {

        $customer = $this->find_customer($id);
        $cartCount = $this->countCart($id);
        $job_orders =  JobOrderUnique::where('user_id', $id)->where('company_id',app('company_id'))->where('cart_order_status',2)->get();

        return view('company.customers.customer_job_orders', compact('customer','job_orders','cartCount'));
    }

    public function transaction_history($id){
        $customer = $this->find_customer($id);
        $cartCount = $this->countCart($id);

        $job_pay_history =  JobPaymentNewHistory::where('user_id',$id)->where('company_id',app('company_id'))->get();
        return view('company.customers.transaction_history', compact('customer','job_pay_history','cartCount'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marketers = User::where('user_type',User::MARKETER)->where('status','active')->where('company_id', app('company_id'))->get();
        return view('company.customers.add_customer', compact('marketers'));
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
            'lastname'  => 'required|string',
            'phone'     => 'required|string',
            'email'     => 'email|string|unique:users,email',
            'address'   => 'required|string',
            'company_school_name'   => 'required|string',
            'marketer_id' => 'nullable',
        ], [
            'firstname.required' => 'Please enter customer firstname.',
            'lastname.required' => 'Please enter customer lastname.',
            'email.required' => 'Please enter customer email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email has been taken.',
            'company_school_name.required' => 'Please enter company name/school name.',
            'phone.required' => 'Please enter customer phone number.',
            'address.required' => 'Please enter customer address.',
        ]);

        try{
            $user = new User();
            $user->company_id   = app('company_id');
            $user->firstname    = request('firstname');
            $user->lastname     = request('lastname');
            $user->email        = request('email');
            $user->phone        = request('phone');
            $user->gender       = request('gender');;
            $user->address      = request('address');
            $user->status       = 'active';
            $user->user_type    = User::CUSTOMER;
            $user->password     = bcrypt(request('firstname'));
            $user->company_name      = request('company_school_name');
            // $user->marketer_id      = request('marketer_id');
            $user->save();

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

        $customer = $this->find_customer($id);
        $cartCount = $this->countCart($id);
        return view('company.customers.view_customer', compact('customer','cartCount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = $this->find_customer($id);
        $cartCount = $this->countCart($id);
        return view('company.customers.edit_customer', compact('customer','cartCount'));
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
            'email'     => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($id),
            ],
        ], [
            'firstname.required' => 'Please enter customer firstname.',
            'lastname.required' => 'Please enter customer lastname.',
            'email.required' => 'Please enter customer email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'phone.required' => 'Please enter customer phone number.',
            'address.required' => 'Please enter customer address.',
        ]);
        try{
            $customer = User::find($id);
            $customer->firstname    = request('firstname');
            $customer->lastname     = request('lastname');
            $customer->email        = request('email');
            $customer->phone        = request('phone');
            $customer->address      = request('address');
            // $customer->company_name      = request('company_school_name');

            $customer->update();
            return back()->with("flash_success","Customer updated successfully");

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
    public function deactivate($id)
    {
        $customer = User::find($id);
        $customer->status = 'deactivated';
        $customer->save();
        return redirect(route('company.customers.all_customers'))->with('flash_success','Customer has been deactivated');
    }

    public function delete($id)
    {
        $customer = User::find($id);
        // $customer->status = 'deactivated';
        $customer->delete();
        return redirect(route('company.customers.all_customers'))->with('flash_success','Customer has been deleted');
    }
}
