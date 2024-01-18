<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\JobOrder;
use App\Models\User;
use App\Models\JobOrderTracking;
use App\Models\ProductCost;
use App\Models\Cart;
use App\Models\OrderApprovedDesign;
use Illuminate\Support\Facades\Auth;
use App\Mail\CustomerOrderReceipt;
use App\Mail\SendContactFormEmail;
use Illuminate\Support\Facades\DB;
use Mail;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Google\Recaptcha\Recaptcha;
class FrontPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $user;
    public $localIp;
    public $order_date;

    public function __construct()
    {
        $this->middleware('auth')->only('track_orders');
        $this->user = Auth::user();
        $this->localIp = $_SERVER['REMOTE_ADDR'];
        $this->order_date = date('Y-m-d');
    }

    private function cartFunc(){
        if (auth()->check()) {
            $cart_func = JobOrder::where('cart_order_status', JobOrder::job_cart_status)
                ->where(function ($query) {
                    $query->where('user_id', $this->user->id)
                        ->orWhere('local_id', $this->localIp);
                })->get();
        } else {
            $cart_func = JobOrder::where('cart_order_status', JobOrder::job_cart_status)->where('local_id', $this->localIp)->get();
        }

        return $cart_func;
    }

    private function countCart(){

        $cart_func = $this->cartFunc();
        $countCart  = count($cart_func);
        return $countCart;
    }


    public function index()
    {
        $cartCount = $this->countCart();
        return view('index', compact('cartCount'));
    }

    public function cart()
    {
        $cartCount = $this->countCart();
        $carts = $this->cartFunc();

        return view('cart.index', compact('cartCount','carts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCart(Request $request, $title =  null, $id =  null)
    {
        try{

        $product_id                 =  request()->id;
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $total_cost                 =  request('total_cost');
        $product_name               =  request('product_name');
        $amount_paid = 0;

        if (Auth::check()) {

             //save to job
            $cart = new JobOrder();
            $cart->product_id      = $product_id;
            $cart->job_order_name  = $product_name;
            $cart->ink             = $ink;
            $cart->paper_type      = $paper_type;
            $cart->quantity        = $quantity;
            $cart->thickness       = $thickness;
            $cart->local_id        = '';
            $cart->cart_order_status = 1;
            $cart->total_cost      = $total_cost;
            $cart->order_date      = $this->order_date;
            $cart->order_type      = 'external';
            $cart->user_id         = $user->id;
            $cart->created_by      = $user->id;
            $cart->save();

        } else {

             //save to job
             $cart = new JobOrder();
             $cart->product_id      = $product_id;
             $cart->job_order_name  = $product_name;
             $cart->ink             = $ink;
             $cart->paper_type      = $paper_type;
             $cart->quantity        = $quantity;
             $cart->thickness       = $thickness;
             $cart->local_id        = $this->localIp;
             $cart->cart_order_status = 1;
             $cart->total_cost      = $total_cost;
             $cart->order_date      = $this->order_date;
             $cart->order_type      = 'external';
            //  $cart->user_id         = '';
            //  $cart->created_by      = '';
             $cart->save();
        }


    }catch(\Exception){
        return redirect()->back()->with('flash_error','An Error Occured: Please try later');
    }

        return redirect(route('cart.index'))->with('flash_success','Product added to cart');
    }

    public function edit_cart($title =  null, $id = null, $job_id =  null)
    {
        $product = Product::where('id', $id)->first();
        $cartCount = $this->countCart();
        $product_costs_higher_education = ProductCost::where('product_name', 'higher_notebook')->get();

        // $product_eighty_leaves = Product::where('id', $id)->first();
        $product_costs_eighty_leaves = ProductCost::where('product_name', 'eighty_leaves')->get();
        $product_costs_forty_leaves = ProductCost::where('product_name', 'forty_leaves')->get();
        $product_costs_twenty_leaves = ProductCost::where('product_name', 'twenty_leaves')->get();

        $product_cost = ProductCost::where('product_id', $id)->first(); //initial pro cost

        return view('cart.edit', compact('cartCount','product','product_costs_higher_education','product_costs_eighty_leaves','product_costs_forty_leaves','product_costs_twenty_leaves','product_cost'));
    }

    public function update_cart(Request $request, $title =  null, $id =  null, $job_id =  null)
    {
        try{

        $product_id                 =  request()->id;
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $total_cost                 =  request('total_cost');
        $product_name               =  request('product_name');
        $amount_paid = 0;

        if (Auth::check()) {

             //save to job
            $cart =  JobOrder::where('id', $job_id)->first();
            $cart->product_id      = $product_id;
            $cart->job_order_name  = $product_name;
            $cart->ink             = $ink;
            $cart->paper_type      = $paper_type;
            $cart->quantity        = $quantity;
            $cart->thickness       = $thickness;
            $cart->local_id        = '';
            $cart->cart_order_status = 1;
            $cart->total_cost      = $total_cost;
            $cart->order_date      = $this->order_date;
            $cart->order_type      = 'external';
            $cart->user_id         = $this->user->id;
            $cart->created_by      = $this->user->id;
            $cart->save();


            $orderDetails   = JobOrder::find($cart->id);

        } else {

             //save to job
             $cart =  JobOrder::where('id', $job_id)->first();
             $cart->product_id      = $product_id;
             $cart->job_order_name  = $product_name;
             $cart->ink             = $ink;
             $cart->paper_type      = $paper_type;
             $cart->quantity        = $quantity;
             $cart->thickness       = $thickness;
             $cart->local_id        = $this->localIp;
             $cart->cart_order_status = 1;
             $cart->total_cost      = $total_cost;
             $cart->order_date      = $this->order_date;
             $cart->order_type      = 'external';

             $cart->save();

             $orderDetails   = JobOrder::find($cart->id);
        }


    }catch(\Exception){
        return redirect()->back()->with('flash_error','An Error Occured: Please try later');
    }

        return redirect(route('cart.index'))->with('flash_success','Product cart edited');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function checkout(){
        if (Auth::check()) {
            $user       =   Auth::user();
            $job_id  = request('job_id');
            $randomInteger = random_int(100000, 999999);

            $checkout =  JobOrder::whereIn('id', $job_id)->update(
                [
                    'user_id'           => $user->id,
                    'cart_order_status' =>  2,
                    'order_no' =>  $randomInteger,
                ]
            );

            //save to tracker
            foreach ($job_id as $ids) {
                DB::table('job_order_trackings')->insert(
                    [
                        'job_order_id' => $ids,
                        'pending_status' => 1,
                        'pending_date' => $this->order_date
                    ]
                );
            }

            $userDetails    = User::find($user->id);
            $userEmail  =  $userDetails->email;
            $userName   =  $userDetails->firstname.' '.$userDetails->lastname;

            $orderDetails   = JobOrder::whereIn('id',$job_id)->get();
            $amount_paid =   0;
            $data = [
                'amount_paid' => 0,
                'userDetails' =>$userDetails,
                'orderDetails' => $orderDetails, // Collection of orders, for example
            ];

            $pdf_attachment = Pdf::loadView('invoice_attachment', $data);
            $sendOrderEmail = Mail::to($userEmail)->send(new CustomerOrderReceipt ($orderDetails,$amount_paid,$userName,$pdf_attachment));
            return redirect(route('track_orders.index'))->with('flash_success','Product Order Successful');

        }else{
            return redirect(route('login', ['status' => 'order']));

        }


    }

    public function product_details($title =  null, $id = null)
    {
        $product = Product::where('id', $id)->first();
        $cartCount = $this->countCart();
        $product_costs_higher_education = ProductCost::where('product_name', 'higher_notebook')->get();

        // $product_eighty_leaves = Product::where('id', $id)->first();
        $product_costs_eighty_leaves = ProductCost::where('product_name', 'eighty_leaves')->get();
        $product_costs_forty_leaves = ProductCost::where('product_name', 'forty_leaves')->get();
        $product_costs_twenty_leaves = ProductCost::where('product_name', 'twenty_leaves')->get();

        $product_cost = ProductCost::where('product_id', $id)->first(); //initial pro cost

        return view('product_details', compact('cartCount','product','product_costs_higher_education','product_costs_eighty_leaves','product_costs_forty_leaves','product_costs_twenty_leaves','product_cost'));
    }

    public function product_categories()
    {
        $cartCount = $this->countCart();
        $product_higher_education = Product::where('name','higher_notebook')->first();
        $forty_leaves = Product::where('name','forty_leaves')->first();
        $twenty_leaves = Product::where('name','twenty_leaves')->first();
        $eighty_leaves = Product::where('name','eighty_leaves')->first();
        return view('product_categories', compact('cartCount','product_higher_education','forty_leaves','twenty_leaves','eighty_leaves'));
    }

    public function getPrice(Request $request){
        $ink            = $request->ink;
        $paper_type     = $request->paper_type;
        $thickness      = $request->thickness;
        $quantity       = $request->quantity;
        $product_name   =  $request->product_name;


        $pro = Product::join('product_costs', 'products.id', '=', 'product_costs.product_id')
        ->where('products.ink',$ink)->where('products.paper_type',$paper_type)->where('products.thickness',$thickness)
        ->where('products.name',$product_name)->where('product_costs.quantity',$quantity)
        ->first();

        $price =  $pro->total_cost;

        return response()->json(['price'=>$price]);
    }


    public function track_orders(){

        $user = Auth::user();
        $carts = JobOrder::where('user_id', $user->id)->where('cart_order_status',2)->get();
        $cartCount = $this->countCart();

        return view('track_orders.index', compact('carts','cartCount'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vieworder($id)
    {
        $cartCount = $this->countCart();
        $user = Auth::user();
        $approved_design  = OrderApprovedDesign::where('job_order_id',$id)->first();
        $job_order_track =  JobOrderTracking::where('job_order_id', $id)->first();
        $order =  JobOrder::where('user_id',$user->id)->where('id', $id)->first();
        return view('track_orders.view', compact('job_order_track','order','approved_design','cartCount'));
    }

    public function orderInvoicePdf($order_no){
        $cartCount = $this->countCart();
        $user = Auth::user();

        // $approved_design  = OrderApprovedDesign::where('job_order_id',$id)->first();
        // $job_order_track =  JobOrderTracking::where('job_order_id', $id)->first();
        $orderDetails =  JobOrder::where('user_id',$user->id)->where('order_no', $order_no)->get();
        $order1 =  JobOrder::where('user_id',$user->id)->where('order_no', $order_no)->first();

        $pdf = PDF::loadView('track_orders.order_invoice_pdf',compact('orderDetails','order1'));
        return $pdf->stream('order_invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        $cartCount = $this->countCart();
        return view('contact.index',compact('cartCount'));
    }

    public function postContact(Request $request)
    {
        //try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required',
                'message' => 'required|string',
                'g-recaptcha-response' => 'required|captcha',
            ]);

            if(!$validator->passes()){
                return response()->json([
                    'status'=>0,
                    'error'=>$validator->errors()->toArray()
                ]);
            }

            $name       = request('name');
            $email      = request('email');
            $phone      = request('phone');
            $title    = request('subject');
            $messagetext    = request('message');

            $send_mail = Mail::to('support@printlabs.com.ng')->send(new SendContactFormEmail ($name, $email, $phone, $title, $messagetext));
            return response()->json([ [1] ]);
        // }catch(\Exception){
        //     return response()->json([ [5] ]);
        // }

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
