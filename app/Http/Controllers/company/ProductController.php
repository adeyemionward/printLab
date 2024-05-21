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
    public function __construct()
    {
        $this->middleware('auth');


        $this->middleware('permission:product-list', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => [
            'add_video_brochure','store_video_brochure','create_higher_education','store_higher_education',
            'create_eighty_leaves','store_eighty_leaves','create_forty_leaves','store_forty_leaves',
            'create_sixty_leaves', 'store_sixty_leaves', 'create_twenty_leaves', 'store_twenty_leaves'
            ]]);

        $this->middleware('permission:product-view', ['only' => ['view']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['delete_product']]);


        $this->startDate  = request('date_from').' 23:59:59';
        $this->endDate    = request('date_to').' 23:59:59';
    }


    function handleFileUpload($hasFile, $fileName, $dir){
        if ($hasFile) {
            if ($img = $fileName) {
                $ImageName = str_replace(' ', '', $fileName->getClientOriginalName());//$fileName->getClientOriginalName();
                $uniqueFileName = time() . '_' . $ImageName;
                $ImagePath = $dir.'/images/' . $uniqueFileName;
                $img->move(public_path($dir.'/images/'), $uniqueFileName);
                return $ImagePath;
            }
        }
    }

    public function subProduct($product_name){
        return $sub_product  =  Product::where('company_id', app('company_id'))->where('name', $product_name)->first();
    }

    public function subProductCost($product_name){
        return $sub_product_cost  =  ProductCost::where('company_id', app('company_id'))->where('product_name', $product_name)->first();
    }

    public function index()
    {
        if(request()->date_to && request()->date_from){
            $products =  Product::whereBetween('created_at', [$this->startDate, $this->endDate])->where('company_id', app('company_id'))->get();
        }else{
            $products =  Product::where('company_id', app('company_id'))->get();
        }


        return view('company.products.all_products',compact('products'));
    }

    public function add_video_brochure()
    {
        return view('company.products.add_video_brochure');
    }

    public function store_video_brochure(Request $request)
    {

        $user = Auth::user();

        $name                       =  request('product_name');
        $title                      =  request('title');
        $quantity                   =  request('quantity');
        $cover_paper                =  request('cover_paper');
        $screen_size                =  request('screen_size');
        $display_area               =  request('display_area');
        $resolution                 =  request('resolution');
        $battery                    =  request('battery');
        $memory                     =  request('memory');
        $total_cost                 =  request('total_cost');
        $screen_ratio               =  request('screen_ratio');
        $description                =  request('description');
        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');

        //save to job
        $product = new Product();
        $product->name              = 'video_brochure';
        $product->title             = $name;
        $product->company_id        = $user->company_id;
        // $product->cover_paper       = $cover_paper;
        $product->screen_size       = $screen_size;
        $product->screen_ratio      = $screen_ratio;
        $product->display_area      = $display_area;
        $product->resolution        = $resolution;
        $product->battery           = $battery;
        $product->image             = $image;
        $product->type              = 'video_brochure';
        $product->description       = $description;
        $product->created_by        = $user->id;


        $product->save();
        //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'product_id'        => $product->id,
                    'company_id'        => $user->company_id,
                    'product_name'      => $product->name,
                    'quantity'          => $quantity[$count],
                    'cover_paper'       => $cover_paper[$count],
                    'memory'            => $memory[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }
        return redirect(route('company.products.all_products'))->with('flash_success','Video Profile saved successfully');
    }


    public function create_higher_education()
    {
        $sub_product  =  $this->subProduct('higher_notebook');
        $sub_product_cost  =  $this->subProductCost('higher_notebook');
        return view('company.products.add_higher_education',compact('sub_product','sub_product_cost'));
    }


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
        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        //save to product
        $product = new Product();

        $product->name            = 'higher_notebook';
        $product->title           = 'Higher Notebook';
         $product->company_id             = $user->company_id;
        // $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->image = $image;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->type              = 'notebook';
        $product->created_by      = $user->id;

        // if($eticket_img = $request->file('image')){
        //     $name = $eticket_img->hashName(); // Generate a unique, random name...
        //     $path = $eticket_img->store('public/images');
        //     $product->image = $name;
        // }

        $product->save();
        //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'company_id'        => $user->company_id,
                    'product_id'        => $product->id,
                    'product_name'      => $product->name,
                    'quantity'          => $quantity[$count],
                    'thickness'         => $thickness[$count],
                    'paper_type'        => $paper_type[$count],
                    'ink'               => $ink[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }
        return redirect(route('company.products.all_products'))->with('flash_success','Higher Note Book product saved successfully');
    }

    public function create_eighty_leaves()
    {
        $sub_product  =  $this->subProduct('eighty_leaves');
        return view('company.products.add_eighty_leaves', compact('sub_product'));
    }



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
        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        //save to job
        $product = new Product();
        $product->name  = 'eighty_leaves';
        $product->title           = 'Eighty Leaves';
        $product->company_id             = $user->company_id;
        // $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->image = $image;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->type              = 'notebook';
        $product->created_by      = $user->id;

       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'company_id'        => $user->company_id,
                    'product_id'        => $product->id,
                    'product_name'        => $product->name,
                    'quantity'          => $quantity[$count],
                    'thickness'         => $thickness[$count],
                    'paper_type'        => $paper_type[$count],
                    'ink'               => $ink[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','Eighty Leaves Book product saved successfully');
    }


    public function create_forty_leaves()
    {
        $sub_product  =  $this->subProduct('forty_leaves');
        return view('company.products.add_forty_leaves', compact('sub_product'));
    }


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
        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        // $payment_type               =  request('payment_type');


        //save to job
        $product = new Product();
        $product->name  = 'forty_leaves';
        $product->title           = 'Forty Leaves';
        $product->company_id             = $user->company_id;
        // $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        // $product->thickness       = $thickness;
        $product->image      = $image;
        $product->description     = $description;
        $product->type              = 'notebook';
        $product->created_by      = $user->id;


       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'company_id'        => $user->company_id,
                    'product_id'        => $product->id,
                    'product_name'        => $product->name,
                    'quantity'          => $quantity[$count],
                    'thickness'         => $thickness[$count],
                    'paper_type'        => $paper_type[$count],
                    'ink'               => $ink[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','Forty Leaves Book product saved successfully');
    }

    public function create_sixty_leaves()
    {
        $sub_product  =  $this->subProduct('sixty_leaves');
        return view('company.products.add_sixty_leaves', compact('sub_product'));
    }


    public function store_sixty_leaves(Request $request)
    {

        $user = Auth::user();
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $description                =  request('description');
        $total_cost                 =  request('total_cost');
        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        //save to job
        $product = new Product();
        $product->name  = 'sixty_leaves';
        $product->title           = 'Sixty Leaves';
        $product->company_id             = $user->company_id;
        // $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->image = $image;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->type              = 'notebook';
        $product->created_by      = $user->id;

       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'company_id'        => $user->company_id,
                    'product_id'        => $product->id,
                    'product_name'      => $product->name,
                    'quantity'          => $quantity[$count],
                    'thickness'         => $thickness[$count],
                    'paper_type'        => $paper_type[$count],
                    'ink'               => $ink[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','Sixty Leaves Book product saved successfully');
    }


    public function create_twenty_leaves()
    {
        $sub_product  =  $this->subProduct('twenty_leaves');
        return view('company.products.add_twenty_leaves',compact('sub_product'));
    }

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

        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        //save to job
        $product = new Product();
        $product->name  = 'twenty_leaves';
        $product->title           = 'Twenty Leaves';
        $product->company_id      = $user->company_id;
        // $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        // $product->thickness       = $thickness;
        $product->image      = $image;
        $product->type              = 'notebook';
        $product->description     = $description;
        $product->created_by      = $user->id;


        // if($eticket_img = $request->file('image')){
        //     $name = $eticket_img->hashName(); // Generate a unique, random name...
        //     $path = $eticket_img->store('public/images');
        //     $product->image = $name;
        // }


       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'company_id'        => $user->company_id,
                    'product_id'        => $product->id,
                    'product_name'        => $product->name,
                    'quantity'          => $quantity[$count],
                    'thickness'         => $thickness[$count],
                    'paper_type'        => $paper_type[$count],
                    'ink'               => $ink[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','Twenty Leaves Book product saved successfully');
    }

    public function create_2A_notebook()
    {
        $sub_product  =  $this->subProduct('2A_notebook');
        return view('company.products.add_2A_notebook', compact('sub_product'));
    }


    public function store_2A_notebook(Request $request)
    {

        $user = Auth::user();
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $description                =  request('description');
        $total_cost                 =  request('total_cost');
        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        //save to job
        $product = new Product();
        $product->name  = '2A_notebook';
        $product->title           = '2A Notebook';
        $product->company_id             = $user->company_id;
        // $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->image = $image;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->type              = 'notebook';
        $product->created_by      = $user->id;

       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'company_id'        => $user->company_id,
                    'product_id'        => $product->id,
                    'product_name'      => $product->name,
                    'quantity'          => $quantity[$count],
                    'thickness'         => $thickness[$count],
                    'paper_type'        => $paper_type[$count],
                    'ink'               => $ink[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','2A Note Book product saved successfully');
    }

    public function create_2B_notebook()
    {
        $sub_product  =  $this->subProduct('2B_notebook');
        return view('company.products.add_2B_notebook', compact('sub_product'));
    }


    public function store_2B_notebook(Request $request)
    {

        $user = Auth::user();
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $description                =  request('description');
        $total_cost                 =  request('total_cost');
        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        //save to job
        $product = new Product();
        $product->name  = '2B_notebook';
        $product->title           = '2B Notebook';
        $product->company_id             = $user->company_id;
        // $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->image = $image;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->type              = 'notebook';
        $product->created_by      = $user->id;

       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'company_id'        => $user->company_id,
                    'product_id'        => $product->id,
                    'product_name'      => $product->name,
                    'quantity'          => $quantity[$count],
                    'thickness'         => $thickness[$count],
                    'paper_type'        => $paper_type[$count],
                    'ink'               => $ink[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','2B Note Book product saved successfully');
    }

    public function create_2D_notebook()
    {
        $sub_product  =  $this->subProduct('2D_notebook');
        return view('company.products.add_2D_notebook', compact('sub_product'));
    }


    public function store_2D_notebook(Request $request)
    {

        $user = Auth::user();
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $thickness                  =  request('thickness');
        $quantity                   =  request('quantity');
        $description                =  request('description');
        $total_cost                 =  request('total_cost');
        $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        //save to job
        $product = new Product();
        $product->name  = '2D_notebook';
        $product->title           = '2D Notebook';
        $product->company_id             = $user->company_id;
        // $product->paper_type      = $paper_type;
        $product->production_days = $production_time;
        $product->image = $image;
        // $product->total_cost      = $total_cost;
        $product->description     = $description;
        $product->type              = 'notebook';
        $product->created_by      = $user->id;

       $product->save();
       //save into product costs
        for ($count=0; $count < count($quantity); $count++) {
            $pro_cost =  ProductCost::updateOrCreate(
                [
                    'company_id'        => $user->company_id,
                    'product_id'        => $product->id,
                    'product_name'      => $product->name,
                    'quantity'          => $quantity[$count],
                    'thickness'         => $thickness[$count],
                    'paper_type'        => $paper_type[$count],
                    'ink'               => $ink[$count],
                    'total_cost'        => $total_cost[$count],
                ],
            );
        }

        return redirect(route('company.products.all_products'))->with('flash_success','2D Note Book product saved successfully');
    }


    public function show($job_title, $id)
    {
        $product =  Product::find($id);
        return view('company.products.view', compact('product'));
    }

    public function edit($job_title, $id)
    {
        $product =  Product::find($id);
        $product_variations = ProductCost::where('product_id', $id)->get();
        return view('company.products.edit', compact('product','product_variations'));
    }


    public function update(Request $request, $job_title, $id){
        $user = Auth::user();
        $product =  Product::find($id);
        $customers =  User::where('user_type',2)->get();
        //dd(request()->job_title);
        if(!is_null($request->file('image'))){
            $image = $this->handleFileUpload($request->hasFile('image'), $request->file('image'), 'products');
        }else{
            $image = $product->image;
        }

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
            // $product->ink             = $ink;
            // $product->paper_type      = $paper_type;
            $product->production_days = $production_time;
            $product->image       = $image;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->created_by      = $user->id;


            $pp =  $product->update();
            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }

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

            $product->production_days = $production_time;
            $product->image       = $image;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->updated_by      = $user->id;


            $pp =  $product->update();
            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }

            return redirect(route('company.products.view',['higher_notebook',$id]))->with('flash_success','Higher Note Book order updated successfully');

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
            //$product->ink             = $ink;
            //$product->paper_type      = $paper_type;
            $product->production_days = $production_time;
            $product->image       = $image;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            $pp =  $product->update();
            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }
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
            $product->image       = $image;
            $product->production_days = $production_time;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            $pp =  $product->update();
            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }

            return redirect(route('company.products.view',['forty_leaves',$id]))->with('flash_success','Forty Leaves Book order updated successfully');
        }elseif(request()->job_title == 'sixty_leaves'){
            
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $quantity                   =  request('quantity');
            $description                =  request('description');
            $total_cost                 =  request('total_cost');

            //save to job
            $product =  Product::find($id);
            $product->name            = 'sixty_leaves';
            $product->image           = $image;
            $product->production_days = $production_time;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            $pp =  $product->update();
            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }

            return redirect(route('company.products.view',['sixty_leaves',$id]))->with('flash_success','Sixty Leaves Book order updated successfully');
       
        
        }elseif(request()->job_title == '2A_notebook'){
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $quantity                   =  request('quantity');
            $description                =  request('description');
            $total_cost                 =  request('total_cost');


            //save to job
            $product =  Product::find($id);
            $product->name  = '2A_notebook';
            //$product->ink             = $ink;
            //$product->paper_type      = $paper_type;
            $product->production_days = $production_time;
            $product->image       = $image;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            $pp =  $product->update();
            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }
            return redirect(route('company.products.view',['2A_notebook',$id]))->with('flash_success','2A Note Book order updated successfully');
        }elseif(request()->job_title == '2B_notebook'){
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $quantity                   =  request('quantity');
            $description                =  request('description');
            $total_cost                 =  request('total_cost');


            //save to job
            $product =  Product::find($id);
            $product->name  = '2B_notebook';
            $product->production_days = $production_time;
            $product->image       = $image;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            $pp =  $product->update();
            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }
            return redirect(route('company.products.view',['2B_notebook',$id]))->with('flash_success','2B Note Book order updated successfully');
        }elseif(request()->job_title == '2D_notebook'){
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $quantity                   =  request('quantity');
            $description                =  request('description');
            $total_cost                 =  request('total_cost');

            //save to job
            $product =  Product::find($id);
            $product->name  = '2D_notebook';
            //$product->ink             = $ink;
            //$product->paper_type      = $paper_type;
            $product->production_days = $production_time;
            $product->image       = $image;
            // $product->total_cost      = $total_cost;
            $product->description     = $description;
            $product->updated_by      = $user->id;

            $pp =  $product->update();
            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'paper_type'        => $paper_type[$count],
                            'thickness'         => $thickness[$count],
                            'ink'               => $ink[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }
            return redirect(route('company.products.view',['2D_notebook',$id]))->with('flash_success','2D Note Book order updated successfully');
        
        }elseif(request()->job_title == 'video_brochure'){
            $name                       =  request('product_name');
            $title                      =  request('title');
            $quantity                   =  request('quantity');
            $cover_paper                =  request('cover_paper');
            $screen_size                =  request('screen_size');
            $display_area               =  request('display_area');
            $resolution                 =  request('resolution');
            $battery                    =  request('battery');
            $memory                     =  request('memory');
            $total_cost                 =  request('total_cost');
            $screen_ratio               =  request('screen_ratio');
            $description                =  request('description');


            //save to job
            $product =  Product::find($id);
            $product->title             = $name;
            $product->screen_size       = $screen_size;
            $product->screen_ratio      = $screen_ratio;
            $product->display_area      = $display_area;
            $product->resolution        = $resolution;
            $product->battery           = $battery;
            $product->image             = $image;
            $product->description       = $description;
            $product->created_by        = $user->id;

            $pp = $product->update();

            $product_cost_id = $request->product_cost_id ?? [];
            if ($pp) {
                for ($count = 0; $count < count($quantity); $count++) {
                    // Check if the product cost ID exists in the request and if it's not empty
                    if (isset($product_cost_id[$count]) && !empty($product_cost_id[$count])) {
                        $existingProduct = ProductCost::find($product_cost_id[$count]);
                    } else {
                        $existingProduct = null;
                    }

                    if ($existingProduct) {
                        // If the product cost already exists, update it
                        $existingProduct->update([
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'cover_paper'       => $cover_paper[$count],
                            'memory'            => $memory[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    } else {
                        // If the product cost doesn't exist, create a new one
                        ProductCost::create([
                            'product_id'        => $id,
                            'product_name'      => $product->name,
                            'quantity'          => $quantity[$count],
                            'cover_paper'       => $cover_paper[$count],
                            'memory'            => $memory[$count],
                            'total_cost'        => $total_cost[$count],
                        ]);
                    }
                }
            }

            return redirect(route('company.products.view',['video_brochure',$id]))->with('flash_success','Video Brochure Product updated successfully');
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
