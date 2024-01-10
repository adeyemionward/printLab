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
use Illuminate\Support\Facades\DB;
use Mail;
use Barryvdh\DomPDF\Facade\Pdf;
class FrontPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->only('track_orders');
    }

    public function index()
    {
        $cartCount = $this->countCart();
        return view('index', compact('cartCount'));
    }

    public function cart()
    {
        $user = Auth::user();
        $localIp = $_SERVER['REMOTE_ADDR'];
        $cartCount = $this->countCart();

        if (auth()->check()) {
            $carts = JobOrder::where('cart_order_status', 1)
                ->where(function ($query) {
                    $query->where('user_id',Auth::user()->id)
                        ->orWhere('local_id', $_SERVER['REMOTE_ADDR']);
                })->get();
        } else {
            $carts = JobOrder::where('cart_order_status', 1)->where('local_id', $localIp)->get();

        }

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
      //  try{
        $user       =   Auth::user();
        $localIp    =   $_SERVER['REMOTE_ADDR'];

        $product_id                 =  request()->id;
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $total_cost                 =  request('total_cost');
        $product_name               =  request('product_name');
        $amount_paid = 0;

        $order_date = date('Y-m-d');

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
            $cart->order_date      = $order_date;
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
             $cart->local_id        = $localIp;
             $cart->cart_order_status = 1;
             $cart->total_cost      = $total_cost;
             $cart->order_date      = $order_date;
             $cart->order_type      = 'external';
            //  $cart->user_id         = '';
            //  $cart->created_by      = '';
             $cart->save();
        }


    // }catch(\Exception){
    //     return redirect()->back()->with('flash_error','An Error Occured: Please try later');
    // }

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
      //  try{
        $user       =   Auth::user();
        $localIp    =   $_SERVER['REMOTE_ADDR'];

        $product_id                 =  request()->id;
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $total_cost                 =  request('total_cost');
        $product_name               =  request('product_name');
        $amount_paid = 0;

        $order_date = date('Y-m-d');

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
            $cart->order_date      = $order_date;
            $cart->order_type      = 'external';
            $cart->user_id         = $user->id;
            $cart->created_by      = $user->id;
            $cart->save();

            //save to cart
            // $job_tracking = new JobOrderTracking();
            // $job_tracking->job_order_id     = $cart->id;
            // $job_tracking->pending_status   = 1;
            // $job_tracking->pending_date     = $order_date;
            // $job_tracking->save();

            // $userDetails    = User::find($user->id);
            // $userEmail      =  $user->email;
            // $userName       =  $user->firstname.' '.$user->lastname;

            // $cart2 = new Cart();
            // $cart2->product_id      = $product_id;
            // $cart2->job_order_id    = $cart->id;
            // $cart2->local_id        = $localIp;
            // $cart2->user_id         = $user->id;

            // $cart2->save();

            $orderDetails   = JobOrder::find($cart->id);
            //$sendOrderEmail =   Mail::to($userEmail)->send(new CustomerOrderReceipt ($orderDetails,$amount_paid,$userName));

        } else {
            // return redirect(route('login', ['status' => 'order']))->with('flash_success','Product Order Successful');

             //save to job
             $cart =  JobOrder::where('id', $job_id)->first();
             $cart->product_id      = $product_id;
             $cart->job_order_name  = $product_name;
             $cart->ink             = $ink;
             $cart->paper_type      = $paper_type;
             $cart->quantity        = $quantity;
             $cart->thickness       = $thickness;
             $cart->local_id        = $localIp;
             $cart->cart_order_status = 1;
             $cart->total_cost      = $total_cost;
             $cart->order_date      = $order_date;
             $cart->order_type      = 'external';

             $cart->save();

             $orderDetails   = JobOrder::find($cart->id);
        }


    // }catch(\Exception){
    //     return redirect()->back()->with('flash_error','An Error Occured: Please try later');
    // }

        return redirect(route('cart.index'))->with('flash_success','Product added to cart');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function countCart(){
        $user = Auth::user();
        $localIp = $_SERVER['REMOTE_ADDR'];
        if (auth()->check()) {
            $cart_count = JobOrder::where('cart_order_status', 1)
                ->where(function ($query) {
                    $query->where('user_id',Auth::user()->id)
                        ->orWhere('local_id', $_SERVER['REMOTE_ADDR']);
                })->get();
        } else {
            $cart_count = JobOrder::where('cart_order_status', 1)->where('local_id', $localIp)->get();

        }
        $countCart  = count($cart_count);
        return $countCart;
    }

    public function checkout(){
        $order_date = date('Y-m-d');
        if (Auth::check()) {
            $user       =   Auth::user();
            $job_id  = request('job_id');

            $checkout =  JobOrder::whereIn('id', $job_id)->update(
                [
                    'user_id'           => $user->id,
                    'cart_order_status' =>  2,
                ]
            );

            //save to tracker
            foreach ($job_id as $ids) {
                DB::table('job_order_trackings')->insert(
                    [
                        'job_order_id' => $ids,
                        'pending_status' => 1,
                        'pending_date' => $order_date
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
