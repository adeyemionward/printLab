<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProfileRequest;
use App\Repository\ProfileRepository;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\JobOrder;
use App\Models\User;
use App\Models\JobOrderTracking;
use App\Models\ProductCost;
use App\Models\Cart;
use App\Models\Testimonial;
use App\Models\OrderApprovedDesign;
use Illuminate\Support\Facades\Auth;
use App\Mail\CustomerOrderReceipt;
use App\Mail\SendContactFormEmail;
use Hash;
use Illuminate\Support\Facades\DB;
use App\Services\CheckoutService;
use App\Models\VideoProfilingProduct;
use App\Models\VideoProfiling;
use App\Models\VideoProfilingProductCost;


use Mail;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
// use Google\Recaptcha\Recaptcha;
class FrontPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;
    public $localIp;
    public $order_date;
    protected $checkoutService;
    public function __construct(CheckoutService $checkoutService)
    {
        $this->middleware('auth')->only('track_orders','profile');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
        $this->checkoutService = $checkoutService;

        $this->localIp = $_SERVER['REMOTE_ADDR'];
        $this->order_date = date('Y-m-d');
    }

    public function VideocartFunc(){
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


    private function VideocartCount(){

        $vieo_cart_func = $this->VideocartFunc();
        $VideoCountCart  = count($vieo_cart_func);
        return $VideoCountCart;
    }

    public function cartFunc(){
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
        $vieo_cart_func = $this->VideocartFunc();
        $VideoCountCart  = count($vieo_cart_func);

        $cart_func = $this->cartFunc();
        $countCart  = count($cart_func);

        return $countCart;
    }

    public function video_brochure(Request $request){
        $all_testimonial = Testimonial::all();
        $cartCount = $this->countCart();
         $video_brochure =  Product::where('type','video_brochure')->get();

        return view('video_brochure.index',  compact('cartCount','all_testimonial','video_brochure'));
    }

    public function video_brochure2(){
        $video_profiling = Product::where('type', 'video_brochure')->where('cover_paper','soft_cover')->get();
        return response()->json(['video_profiling'=>$video_profiling]);;
    }

    public function video_brochure3(Request $request){
        $coverType = $request->input('coverType');
        $video_profiling = Product::where('type', 'video_brochure')->where('cover_paper', $coverType)->get();
        return response()->json(['video_profiling'=>$video_profiling]);;
    }


     public function video_brochure_details(Request $request, $title =  null, $id = null){
        //return $title_1 = request('title_1');
        // $video_profiling_pricing = Product::join('product_costs', 'products.id', '=', 'product_costs.product_id')->where('products.title',$title_1)
        // ->get();

        $all_testimonial = Testimonial::all();
        $cartCount = $this->countCart();
        $video_profiling =  Product::find($id);
        $video_profiling_pricing =  ProductCost::where('product_id',$id)->get();
        $product_memory =  Product::where('id',$id)->get();
        $product_cost = ProductCost::where('product_id', $id)->first(); //initial pro cost
        return view('video_brochure.product_details', compact('cartCount','all_testimonial','video_profiling','video_profiling_pricing','product_cost','product_memory'));
    }


    public function addVideoBrochureCart(Request $request, $title =  null, $id =  null)
    {
        //try{

        $product_id                 =  request()->id;
        $cover_paper                =  request('cover_paper');
        $quantity                   =  request('quantity');
        $total_cost                 =  request('total_cost');
        $product_name               =  request('product_name');
        $amount_paid = 0;

        if (Auth::check()) {

            //save to job
            $cart = new JobOrder();
            $cart->product_id      = $product_id;
            $cart->job_order_name  = $product_name;
            $cart->quantity        = $quantity;
            $cart->local_id        = $this->localIp;
            $cart->cart_order_status = 1;
            $cart->total_cost      = $total_cost;
            $cart->cover_paper      = $cover_paper;

            $cart->order_date      = $this->order_date;
            $cart->order_type      = 'external';
            $cart->user_id         = $this->user->id;
            $cart->created_by      = $this->user->id;
            $cart->save();

        } else {

            //save to job
            $cart = new JobOrder();
            $cart->product_id      = $product_id;
            $cart->job_order_name  = $product_name;
            $cart->quantity        = $quantity;
            $cart->local_id        = $this->localIp;
            $cart->cover_paper      = $cover_paper;
            $cart->cart_order_status = 1;
            $cart->total_cost      = $total_cost;
            $cart->order_date      = $this->order_date;
            $cart->order_type      = 'external';
            $cart->save();
        }


    // }catch(\Exception $th){
    //     return redirect()->back()->with('flash_error','An Error Occured: Please try later');
    // }
        return redirect(route('cart.index'))->with('flash_success','Product added to cart');
    }

    public function index()
    {
        $all_testimonial = Testimonial::all();
        $cartCount = $this->countCart();
        $video_brochure =  Product::where('type','video_brochure')->take(4)->get();
        return view('index', compact('cartCount','all_testimonial','video_brochure'));
    }

    public function cart()
    {
        $cartCount = $this->countCart();
        $carts = $this->cartFunc();

        $VideocartCount = $this->VideocartCount();
        $videocarts = $this->VideocartFunc();
        $products = Product::all();
        return view('cart.index', compact('cartCount','carts','VideocartCount','videocarts','products'));
    }

    // public function addCart(Request $request, $title =  null, $id =  null)
    // {
    //     try{

    //     $product_id                 =  request()->id;
    //     $ink                        =  request('ink');
    //     $paper_type                 =  request('paper_type');
    //     $thickness                  =  request('thickness');
    //     $quantity                   =  request('quantity');
    //     $total_cost                 =  request('total_cost');
    //     $memory                     =  request('memory');
    //     $cover_paper                =  request('cover_paper');
    //     $product_name               =  request('product_name');
    //     $amount_paid = 0;

    //     if (Auth::check()) {

    //         //save to job
    //         $cart = new JobOrder();
    //         $cart->product_id      = $product_id;
    //         $cart->job_order_name  = $product_name;
    //         $cart->ink             = $ink;
    //         $cart->paper_type      = $paper_type;
    //         $cart->quantity        = $quantity;
    //         $cart->thickness       = $thickness;
    //         $cart->local_id        = $this->localIp;
    //         $cart->cart_order_status = 1;
    //         $cart->total_cost      = $total_cost;
    //         $cart->memory          = $memory;
    //         $cart->cover_paper     = $cover_paper;
    //         $cart->order_date      = $this->order_date;
    //         $cart->order_type      = 'external';
    //         $cart->user_id         = $this->user->id;
    //         $cart->created_by      = $this->user->id;
    //         $cart->save();

    //     } else {

    //         //save to job
    //         $cart = new JobOrder();
    //         $cart->product_id      = $product_id;
    //         $cart->job_order_name  = $product_name;
    //         $cart->ink             = $ink;
    //         $cart->paper_type      = $paper_type;
    //         $cart->quantity        = $quantity;
    //         $cart->thickness       = $thickness;
    //         $cart->local_id        = $this->localIp;
    //         $cart->cart_order_status = 1;
    //         $cart->total_cost      = $total_cost;
    //         $cart->memory          = $memory;
    //         $cart->cover_paper     = $cover_paper;
    //         $cart->order_date      = $this->order_date;
    //         $cart->order_type      = 'external';
    //         //  $cart->user_id         = '';
    //         //  $cart->created_by      = '';
    //         $cart->save();
    //     }


    // }catch(\Exception $th){
    //     return redirect()->back()->with('flash_error','An Error Occured: Please try later');
    // }

    //     return redirect(route('cart.index'))->with('flash_success','Product added to cart');
    // }

    public function addCart(Request $request, $title = null, $id = null)
    {
    try {
        $product_id    = request()->id;
        $ink           = request('ink');
        $paper_type    = request('paper_type');
        $thickness     = request('thickness');
        $quantity      = request('quantity');
        $total_cost    = request('total_cost');
        $memory        = request('memory');
        $cover_paper   = request('cover_paper');
        $product_name  = request('product_name');
        $amount_paid   = 0;

        if (Auth::check()) {
            $user_id = $this->user->id;
            $existingCart = JobOrder::where(function ($query) use ($user_id, $product_id) {
                $query->where('user_id', $user_id)
                    ->orWhere('local_id', $this->localIp);
            })->where('product_id', $product_id)->where('cart_order_status', 1)->first();


            if ($existingCart) {
               // return 'old';
                // Update existing cart
                $existingCart->update([
                    'ink'           => $ink,
                    'paper_type'    => $paper_type,
                    'quantity'      => $existingCart->quantity + $quantity, // Update quantity
                    'thickness'     => $thickness,
                    'total_cost'    => $existingCart->total_cost + $total_cost, // Update total cost
                    'memory'        => $memory,
                    'cover_paper'   => $cover_paper,
                ]);
            } else {
                //return 'new';
                // Create new cart
                $cart = new JobOrder();
                $cart->user_id            = $user_id;
                $cart->product_id         = $product_id;
                $cart->job_order_name     = $product_name;
                $cart->ink                = $ink;
                $cart->paper_type         = $paper_type;
                $cart->quantity           = $quantity;
                $cart->thickness          = $thickness;
                $cart->local_id           = $this->localIp;
                $cart->cart_order_status  = 1;
                $cart->total_cost         = $total_cost;
                $cart->memory             = $memory;
                $cart->cover_paper        = $cover_paper;
                $cart->order_date         = $this->order_date;
                $cart->order_type         = 'external';
                $cart->user_id          = $this->user->id;
                $cart->created_by         = $user_id;
                $cart->save();
            }
        } else {

            $existingCart = JobOrder::where('product_id', $product_id)
            ->where(function ($query) {
                $query->where('local_id', $this->localIp);
            })->where('product_id', $product_id)->where('cart_order_status', 1)->first();

            if ($existingCart) {
                // Update existing cart
                $existingCart->update([
                    'ink'           => $ink,
                    'paper_type'    => $paper_type,
                    'quantity'      => $existingCart->quantity + $quantity, // Update quantity
                    'thickness'     => $thickness,
                    'total_cost'    => $existingCart->total_cost + $total_cost, // Update total cost
                    'memory'        => $memory,
                    'cover_paper'   => $cover_paper,
                ]);
            }else{
                        // Handle case where user is not authenticated
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
                $cart->memory          = $memory;
                $cart->cover_paper     = $cover_paper;
                $cart->order_date      = $this->order_date;
                $cart->order_type      = 'external';
                //  $cart->user_id         = '';
                //  $cart->created_by      = '';
                $cart->save();
            }
        }

        return redirect(route('cart.index'))->with('flash_success', 'Product added to cart');
    } catch (\Exception $th) {
        return redirect()->back()->with('flash_error', 'An Error Occured: Please try later');
    }
    }


    public function edit_cart($title =  null, $id = null, $job_id =  null)
    {
        $product = Product::where('id', $id)->first();
        $cartCount = $this->countCart();
        $product_costs_higher_education = ProductCost::where('product_name', 'higher_notebook')->get();

        $video_profiling_memory     = ProductCost::where('product_name', 'video_brochure')->where('product_id',$id)->distinct()->get('memory');
        $video_profiling_quantity   = ProductCost::where('product_name', 'video_brochure')->where('product_id',$id)->distinct()->get('quantity');

        // $product_eighty_leaves = Product::where('id', $id)->first();
        $product_costs_eighty_leaves = ProductCost::where('product_name', 'eighty_leaves')->get();
        $product_costs_forty_leaves = ProductCost::where('product_name', 'forty_leaves')->get();
        $product_costs_twenty_leaves = ProductCost::where('product_name', 'twenty_leaves')->get();

        $product_cost = ProductCost::where('product_id', $id)->first(); //initial pro cost

        return view('cart.edit', compact('cartCount','product','product_costs_higher_education','product_costs_eighty_leaves','product_costs_forty_leaves','product_costs_twenty_leaves','product_cost','video_profiling_memory','video_profiling_quantity'));
    }

    public function delete_cart($id)
    {
        $product = JobOrder::where('id', $id)->delete();
        return redirect(route('cart.index'))->with('flash_success','Product cart deleted');
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
        $memory                     =  request('memory');
        $cover_paper                =  request('cover_paper');
        $product_name               =  request('product_name');
        $amount_paid = 0;

        if (Auth::check()) {
            //save to job
            $cart =  JobOrder::where('id', $job_id)->first();
            $cart->product_id      = $product_id;
            // $cart->job_order_name  = $product_name;
            $cart->ink             = $ink;
            $cart->paper_type      = $paper_type;
            $cart->quantity        = $quantity;
            $cart->thickness       = $thickness;
            $cart->local_id        = $this->localIp;
            $cart->cart_order_status = 1;
            $cart->total_cost      = $total_cost;
            $cart->memory          = $memory;
            $cart->cover_paper     = $cover_paper;
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
            //  $cart->job_order_name  = $product_name;
             $cart->ink             = $ink;
             $cart->paper_type      = $paper_type;
             $cart->quantity        = $quantity;
             $cart->thickness       = $thickness;
             $cart->local_id        = $this->localIp;
             $cart->cart_order_status = 1;
             $cart->total_cost      = $total_cost;
             $cart->memory          = $memory;
             $cart->cover_paper     = $cover_paper;
             $cart->order_date      = $this->order_date;
             $cart->order_type      = 'external';

             $cart->save();

             $orderDetails   = JobOrder::find($cart->id);
        }


    }catch(\Exception $th){
        return redirect()->back()->with('flash_error','An Error Occured: Please try later');
    }

        return redirect(route('cart.index'))->with('flash_success','Product cart edited');
    }


    public function checkout(){
        return $this->checkoutService->processCheckout();
    }

    public function product_details($title =  null, $id = null)
    {
        $product = Product::where('id', $id)->first();
        if(is_null($product)) return redirect()->back()->with('flash_error','The product does not exist');
        $cartCount = $this->countCart();
        if($title == 'Higher_Education') $higher_note =  'higher_notebook';
        $product_costs_higher_education = ProductCost::where('product_name', 'higher_notebook')->get();

        $video_profiling_memory     = ProductCost::where('product_name', 'video_brochure')->where('product_id',$id)->distinct()->get('memory');
        $video_profiling_quantity   = ProductCost::where('product_name', 'video_brochure')->where('product_id',$id)->distinct()->get('quantity');

        $product_costs_eighty_leaves = ProductCost::where('product_name', 'eighty_leaves')->get();
        $product_costs_forty_leaves = ProductCost::where('product_name', 'forty_leaves')->get();
        $product_costs_twenty_leaves = ProductCost::where('product_name', 'twenty_leaves')->get();
        $product_memory =  Product::where('id',$id)->get();
        $product_cost = ProductCost::where('product_id', $id)->first(); //initial pro cost

        return view('product_details', compact('cartCount','product','product_costs_higher_education','product_costs_eighty_leaves','product_costs_forty_leaves','product_costs_twenty_leaves','product_cost','product_memory','video_profiling_memory','video_profiling_quantity'));
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

    public function getVideoProfilePrice(Request $request, $title, $id){

        $quantity       =   $request->quantity;
        $memory         =   $request->memory;
        $cover_paper     =   $request->cover_paper;

        $pro = Product::join('product_costs', 'products.id', '=', 'product_costs.product_id')
        ->where('product_costs.quantity',$quantity)->where('product_costs.memory',$memory)
        ->where('product_costs.cover_paper',$cover_paper)->where('products.id',request()->id)
        ->first();

        $price =  $pro->total_cost;

        return response()->json(['price'=>$price]);
    }

    public function getPrice(Request $request, $title, $id){

        $ink            = $request->ink;
        $paper_type     = $request->paper_type;
        $thickness      = $request->thickness;
        $quantity       = $request->quantity;
        $product_name   =  $request->product_name;

        if(request()->title =='Higher_Education') request()->title = 'higher_notebook';
        $pro = Product::join('product_costs', 'products.id', '=', 'product_costs.product_id')
        ->where('product_costs.ink',$ink)->where('product_costs.paper_type',$paper_type)->where('product_costs.thickness',$thickness)
        ->where('product_costs.quantity',$quantity)->where('products.id',request()->id)->where('products.name',request()->title)
        ->first();

        $price =  $pro->total_cost;

        return response()->json(['price'=>$price]);
    }


    public function track_orders(){

        $user = Auth::user();
        $carts = JobOrder::where('user_id', $user->id)
        ->where('cart_order_status',JobOrder::ORDER_COMPLETED)
        ->where('order_no','!=', NULL)->orderBy('id','DESC')
        ->get();
        $cartCount = $this->countCart();

        return view('track_orders.index', compact('carts','cartCount'));
    }


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
        $user   = Auth::user();
        $job    =  JobOrder::where('user_id',$user->id)->where('order_no', $order_no);
        $orderDetails   =  $job->get();
        $order1         =  $job->first();

        $pdf = PDF::loadView('track_orders.order_invoice_pdf',compact('orderDetails','order1'));
        return $pdf->stream('order_invoice.pdf');
    }


    public function contact()
    {
        $cartCount = $this->countCart();
        return view('contact.index',compact('cartCount'));
    }

    public function postContact(Request $request)
    {
        try{
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

            $send_mail = Mail::to('info@printlabs.com.ng')->send(new SendContactFormEmail ($name, $email, $phone, $title, $messagetext));
            return response()->json([ [1] ]);
        }catch(\Throwable $th){
            return response()->json([ [5] ]);
        }

    }


    public function profile()
    {
        $cartCount = $this->countCart();
        return view('profile.index',compact('cartCount'));
    }

    public function updateProfile(ProfileRequest $request, ProfileRepository $profileRepository)
    {

        $result = $profileRepository->storeProfile($request->all());

        if ($result['success']) {
            // creation was successful
            $redirectResponse =  response()->json([ [1] ]);
            //redirect(route('profile.index'))->with('flash_success','Profile updated successfully');
        } else {
            // creation failed
            $redirectResponse =  response()->json([ [2] ]);
            //redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }
        return $redirectResponse;

    }

    public function changePassword()
    {
        $cartCount = $this->countCart();
        return view('profile.change_password',compact('cartCount'));
    }

    public function updateChangePassword(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8', // Password confirmation and minimum length
        ]);

        if(!$validate->passes()){
            return response()->json([
                'status'=>0,
                'error'=>$validate->errors()->toArray()
            ]);
        }

        $user = Auth::user();
        try{
            if (Hash::check(request('old_password'), $user->password)) {
                $user->password = bcrypt(request('password'));
                $user->save();
                return response()->json([ [1] ]);
            }else{
                return response()->json([ [2] ]);
            }
        }catch (\Throwable $th){
            // ErrorLog::log('user_password', 'null', $th->getMessage()); //log error
            // return $th->getMessage();
            return response()->json([ [5] ]);
        }
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
