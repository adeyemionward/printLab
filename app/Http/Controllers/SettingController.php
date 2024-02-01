<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpenseCategory;
use App\Models\User;
use App\Models\Testimonial;
class SettingController extends Controller
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
    public function all_category()
    {
        return view('settings.category.all_category');
    }

    public function create_category()
    {
        return view('settings.category.add_category');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function post_category()
    {
        $user = Auth::user();
        //save into locations

        $name                 =  request('name');
        for ($count=0; $count < count($name); $count++) {
            $order_location =  ExpenseCategory::updateOrCreate(
                [
                    'category_name'          => $name[$count],
                    'created_by'    => $user->id,
                ],
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_testimonial()
    {
        $customers =  User::where('user_type',User::CUSTOMER)->get();
        return view('settings.testimonial.add_testimonial', compact('customers'));
    }

    public function post_testimonial(Request $request)
    {

        $user = Auth::user();

        $customer_id   =  request('customer_id');
        $description    =  request('description');


        //save to testimonial
        $testimonial = new Testimonial();
        $testimonial->customer_id     =  $customer_id;
        $testimonial->description     = $description;
        $testimonial->created_by          = $user->id;


        if($testimonial_img = $request->file('image')){
            $name = $testimonial_img->hashName(); // Generate a unique, random name...
            $path = $testimonial_img->store('public/images');
            $testimonial->image = $name;

        }

        $testimonial->save();

        return redirect(route('settings.testimonial.add_testimonial'))->with('flash_success','Customer Testimonial saved successfully');
    }

    public function all_testimonial()
    {
        $all_testimonial = Testimonial::all();
        return view('settings.category.all_testimonial', compact('all_testimonial'));
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
