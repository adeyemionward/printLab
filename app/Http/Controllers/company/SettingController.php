<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpenseCategory;
use App\Models\User;
use App\Models\Testimonial; 
use App\Models\SiteSetting; 
use App\Services\Company\ColorLogoService;
use App\Services\Company\AddressService;
use App\Services\Company\HeroTextService;
use App\Services\Company\EmailService;
use App\Services\Company\PhoneService;
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
        return view('company.settings.category.all_category');
    }

    public function create_category()
    {
        return view('company.settings.category.add_category');
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

    private function siteDetails (){
        $user = Auth::user();
        return SiteSetting::where('company_id', $user->company_id)->first();
    }

    public function color_logo(){
        return view('company.settings.site.color_logo');
    }

    public function storeColorLogo(Request $request, ColorLogoService $colorlogoservice){
        return $colorlogoservice->postColorLogo($request);
    }

    public function hero_text(){
        return view('company.settings.site.hero_text');
    }

    public function storeHeroText(Request $request, HeroTextService $herotextservice){
        return $herotextservice->postHeroText($request);
    }

    public function address(){
        return view('company.settings.site.address');
    }

    public function storeAddress(Request $request, AddressService $addressservice){
        return $addressservice->postAddress($request);
    }
    
    public function email(){
        return view('company.settings.site.email');
    }

    public function storeEmail(Request $request, EmailService $emailservice){
        return $emailservice->postEmail($request);
    }

    public function phone(){
        return view('company.settings.site.phone');
    }

    public function storePhone(Request $request, PhoneService $phoneservice){
        return $phoneservice->postPhone($request);
    }
}
