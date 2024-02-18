<?php

namespace App\Http\Controllers\Admin;

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
}
