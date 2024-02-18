<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductCost;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->startDate  = request('date_from').' 23:59:59';
        $this->endDate    = request('date_to').' 23:59:59';
    }
    public function index()
    {
        if(request()->date_to && request()->date_from){
            $products = Product::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        }else{
            $products =  Product::all();
        }


        return view('company.products.all_products',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_higher_education()
    {
        return view('company.products.add_higher_education');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_higher_education(Request $request)
    {

        $user = Auth::user();

        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $description                =  request('description');
        $total_cost                 =  request('total_cost');


        //save to product
        $product = new Product();
        $product->name  = 'higher_notebook';
        $product->ink             = $ink;
        $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->thickness       = $thickness;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->created_by      = $user->id;

        if($eticket_img = $request->file('image')){
            $name = $eticket_img->hashName(); // Generate a unique, random name...
            $path = $eticket_img->store('public/images');
            $product->image = $name;
        }

        $product->save();
        //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'product_id'        => $product->id,
                    'product_name'        => $product->name,
                    'quantity'          => $quantity[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }
        return redirect(route('company.products.all_products'))->with('flash_success','Higher Note Book product saved successfully');
    }

    public function create_eighty_leaves()
    {
        return view('company.products.add_eighty_leaves');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_eighty_leaves(Request $request)
    {

        $user = Auth::user();

        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $description                =  request('description');
        $total_cost                 =  request('total_cost');


        //save to job
        $product = new Product();
        $product->name  = 'eighty_leaves';
        $product->ink             = $ink;
        $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->thickness       = $thickness;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->created_by      = $user->id;


        if($eticket_img = $request->file('image')){
            $name = $eticket_img->hashName(); // Generate a unique, random name...
            $path = $eticket_img->store('public/images');
            $product->image = $name;
        }


       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'product_id'        => $product->id,
                    'product_name'        => $product->name,
                    'quantity'          => $quantity[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','Eighty Leaves Book product saved successfully');
    }


    public function create_forty_leaves()
    {
        return view('company.products.add_forty_leaves');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_forty_leaves(Request $request)
    {
        $user = Auth::user();

        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $description                =  request('description');
        $total_cost                 =  request('total_cost');
        // $payment_type               =  request('payment_type');


        //save to job
        $product = new Product();
        $product->name  = 'forty_leaves';
        $product->ink             = $ink;
        $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->thickness       = $thickness;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->created_by      = $user->id;


        if($eticket_img = $request->file('image')){
            $name = $eticket_img->hashName(); // Generate a unique, random name...
            $path = $eticket_img->store('public/images');
            $product->image = $name;
        }


       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'product_id'        => $product->id,
                    'product_name'        => $product->name,
                    'quantity'          => $quantity[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','Forty Leaves Book product saved successfully');
    }

    public function create_twenty_leaves()
    {
        return view('company.products.add_twenty_leaves');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_twenty_leaves(Request $request)
    {

        $user = Auth::user();

        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $description                =  request('description');
        $total_cost                 =  request('total_cost');


        //save to job
        $product = new Product();
        $product->name  = 'twenty_leaves';
        $product->ink             = $ink;
        $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->thickness       = $thickness;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->created_by      = $user->id;


        if($eticket_img = $request->file('image')){
            $name = $eticket_img->hashName(); // Generate a unique, random name...
            $path = $eticket_img->store('public/images');
            $product->image = $name;
        }


       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'product_id'        => $product->id,
                    'product_name'        => $product->name,
                    'quantity'          => $quantity[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','Twenty Leaves Book product saved successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($job_title, $id)
    {
        $product =  Product::find($id);
        return view('company.products.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($job_title, $id)
    {
        $product =  Product::find($id);
        return view('company.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $job_title, $id){
        $user = Auth::user();
        $job_order =  Product::find($id);
        $customers =  User::where('user_type',2)->get();
        //dd(request()->job_title);
        if(request()->job_title == 'eighty_leaves'){
            $user = Auth::user();

            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $quantity                   =  request('quantity');
            $description                =  request('description');
            $total_cost                 =  request('total_cost');


            //save to job
        $product =  Product::find($id);
        $product->name  = 'eighty_leaves';
        $product->ink             = $ink;
        $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->thickness       = $thickness;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->created_by      = $user->id;

        if(!empty($request->file('image'))){
            if($eticket_img = $request->file('image')){
                $name = $eticket_img->hashName(); // Generate a unique, random name...
                $path = $eticket_img->store('public/images');
                $product->image = $name;
            }
        }


        $product->save();

         return redirect(route('company.products.view',['eighty_leaves',$id]))->with('flash_success','Eighty Leaves Book order updated successfully');


        }elseif(request()->job_title == 'higher_notebook'){

            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $quantity                   =  request('quantity');
            $description                =  request('description');
            $total_cost                 =  request('total_cost');


            //save to job
            $product =  Product::find($id);
            $product->name  = 'higher_notebook';
            $product->ink             = $ink;
            $product->paper_type      = $paper_type;
            $product->production_days = $production_time;
            $product->thickness       = $thickness;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            if(!empty($request->file('image'))){
                if($eticket_img = $request->file('image')){
                    $name = $eticket_img->hashName(); // Generate a unique, random name...
                    $path = $eticket_img->store('public/images');
                    $product->image = $name;
                }
            }
            $product->save();

            return redirect(route('products.view',['higher_notebook',$id]))->with('flash_success','Higher Note Book order updated successfully');

        }elseif(request()->job_title == 'twenty_leaves'){
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $quantity                   =  request('quantity');
            $description                =  request('description');
            $total_cost                 =  request('total_cost');


            //save to job
            $product =  Product::find($id);
            $product->name  = 'twenty_leaves';
            $product->ink             = $ink;
            $product->paper_type      = $paper_type;
            $product->production_days = $production_time;
            $product->thickness       = $thickness;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            if(!empty($request->file('image'))){
                if($eticket_img = $request->file('image')){
                    $name = $eticket_img->hashName(); // Generate a unique, random name...
                    $path = $eticket_img->store('public/images');
                    $product->image = $name;
                }
            }
            $product->save();
            return redirect(route('company.products.view',['twenty_leaves',$id]))->with('flash_success','Twenty Leaves Book order updated successfully');
        }elseif(request()->job_title == 'forty_leaves'){

            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $quantity                   =  request('quantity');
            $description                =  request('description');
            $total_cost                 =  request('total_cost');


            //save to job
            $product =  Product::find($id);
            $product->name  = 'forty_leaves';
            $product->ink             = $ink;
            $product->paper_type      = $paper_type;
            $product->production_days = $production_time;
            $product->thickness       = $thickness;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            if(!empty($request->file('image'))){
                if($eticket_img = $request->file('image')){
                    $name = $eticket_img->hashName(); // Generate a unique, random name...
                    $path = $eticket_img->store('public/images');
                    $product->image = $name;
                }
            }
            $product->save();

            return redirect(route('company.products.view',['forty_leaves',$id]))->with('flash_success','Forty Leaves Book order updated successfully');
        }
    }


    public function edit_pricing ($job_title, $id){
        $costs =  ProductCost::where('product_id', $id)->get();
        return view('company.products.edit_pricing', compact('costs'));
    }

    public function update_pricing ($job_title, $id){
        $costs =  ProductCost::where('product_id', $id)->get();

        $quantity                 =  request('quantity');
        $total_cost                 =  request('total_cost');


        try{
            $delete_cost  = ProductCost::where('product_id',$id)->delete(); //delete all cost for unique ID

            for ($count=0; $count < count($quantity); $count++) {
                $pro_cost =  ProductCost::updateOrCreate(
                    [
                        'product_id'        => $id,
                        'product_name'      => $job_title,
                        'quantity'          => $quantity[$count],
                        'total_cost'        => $total_cost[$count],

                    ],
                );
            }
        }catch (\Throwable $th){
            ErrorLog::log('product', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }


        return redirect(route('company.products.edit_pricing',[$job_title, $id]))->with('flash_success','Product Pricing updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_product($id)
    {
        $delete_product  = Product::where('id',$id)->delete();
        return redirect(route('company.products.all_products'))->with('flash_success','Product deleted successfully');
    }
}
