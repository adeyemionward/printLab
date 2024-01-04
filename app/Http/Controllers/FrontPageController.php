<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\JobOrder;
use App\Models\User;
use App\Models\JobOrderTracking;
use App\Models\ProductCost;
use Illuminate\Support\Facades\Auth;
use App\Mail\CustomerOrderReceipt;
use Mail;
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
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product_details($title =  null, $id = null)
    {
        $product = Product::where('id', $id)->first();
        $product_costs_higher_education = ProductCost::where('product_name', 'higher_notebook')->get();

        // $product_eighty_leaves = Product::where('id', $id)->first();
        $product_costs_eighty_leaves = ProductCost::where('product_name', 'eighty_leaves')->get();
        $product_costs_forty_leaves = ProductCost::where('product_name', 'forty_leaves')->get();
        $product_costs_twenty_leaves = ProductCost::where('product_name', 'twenty_leaves')->get();

        $product_cost = ProductCost::where('product_id', $id)->first(); //initial pro cost

        return view('product_details', compact('product','product_costs_higher_education','product_costs_eighty_leaves','product_costs_forty_leaves','product_costs_twenty_leaves','product_cost'));
    }

    public function product_categories()
    {
        $product_higher_education = Product::where('name','higher_notebook')->get();
        $forty_leaves = Product::where('name','forty_leaves')->get();
        $twenty_leaves = Product::where('name','twenty_leaves')->get();
        $eighty_leaves = Product::where('name','eighty_leaves')->get();
        return view('product_categories', compact('product_higher_education','forty_leaves','twenty_leaves','eighty_leaves'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCart(Request $request, $title =  null, $id =  null)
    {
      //  try{
        $user = Auth::user();


        $product_id                 =  request()->id;
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $total_cost                 =  request('total_cost');
        $product_name                 =  request('product_name');
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
            $cart->total_cost      = $total_cost;
            $cart->order_date      = $order_date;
            $cart->order_type      = 'external';
            $cart->user_id         = $user->id;
            $cart->created_by      = $user->id;
            $cart->save();

            //save to cart
            $job_tracking = new JobOrderTracking();
            $job_tracking->job_order_id     = $cart->id;
            $job_tracking->pending_status   = 1;
            $job_tracking->pending_date     = $order_date;
            $job_tracking->save();

            $userDetails    = User::find($user->id);
            $userEmail      =  $user->email;
            $userName       =  $user->firstname.' '.$user->lastname;

            $orderDetails   = JobOrder::find($cart->id);
            $sendOrderEmail =   Mail::to($userEmail)->send(new CustomerOrderReceipt ($orderDetails,$amount_paid,$userName));

        } else {
            return redirect(route('login', ['status' => 'order']))->with('flash_success','Product Order Successful');
        }


    // }catch(\Exception){
    //     return redirect()->back()->with('flash_error','An Error Occured: Please try later');
    // }

        return redirect(route('track_orders.index'))->with('flash_success','Product added to cart');
    }

    public function track_orders(){
        $user = Auth::user();
        $carts = JobOrder::where('user_id', $user->id)->where('order_type','external')->get();
        return view('track_orders.index', compact('carts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vieworder($id)
    {
        $user = Auth::user();
        $job_order_track =  JobOrderTracking::where('job_order_id', $id)->first();
        $order =  JobOrder::where('user_id',$user->id)->where('id', $id)->first();
        return view('track_orders.view', compact('job_order_track','order'));
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
