<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
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
    }
    public function index()
    {
        $products =  Product::all();
        return view('products.all_products',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_higher_education()
    {
        return view('products.add_higher_education');
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
            // foreach ($eticket_imgs as $eticket_img) {
            $filename = substr (md5($eticket_img),0,8);
            $extension = $eticket_img->extension();
            $getFileExt = $filename.'.'.$extension;
            $eticket_img->move(public_path('product_images/'), $getFileExt);
            $product->image = $getFileExt;
            // }
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
        return redirect(route('products.all_products'))->with('flash_success','Higher Note Book product saved successfully');
    }

    public function create_eighty_leaves()
    {
        return view('products.add_eighty_leaves');
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
            // foreach ($eticket_imgs as $eticket_img) {
            $filename = substr (md5($eticket_img),0,8);
            $extension = $eticket_img->extension();
            $getFileExt = $filename.'.'.$extension;
            $eticket_img->move(public_path('product_images/'), $getFileExt);
            $product->image = $getFileExt;
            // }
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

        return redirect(route('products.all_products'))->with('flash_success','Eighty Leaves Book product saved successfully');
    }


    public function create_forty_leaves()
    {
        return view('products.add_forty_leaves');
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
            // foreach ($eticket_imgs as $eticket_img) {
            $filename = substr (md5($eticket_img),0,8);
            $extension = $eticket_img->extension();
            $getFileExt = $filename.'.'.$extension;
            $eticket_img->move(public_path('product_images/'), $getFileExt);
            $product->image = $getFileExt;
            // }
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

        return redirect(route('products.all_products'))->with('flash_success','Forty Leaves Book product saved successfully');
    }

    public function create_twenty_leaves()
    {
        return view('products.add_twenty_leaves');
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
            // foreach ($eticket_imgs as $eticket_img) {
            $filename = substr (md5($eticket_img),0,8);
            $extension = $eticket_img->extension();
            $getFileExt = $filename.'.'.$extension;
            $eticket_img->move(public_path('product_images/'), $getFileExt);
            $product->image = $getFileExt;
            // }
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

        return redirect(route('products.all_products'))->with('flash_success','Twenty Leaves Book product saved successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
