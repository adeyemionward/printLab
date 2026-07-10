<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpenseCategory;
use App\Models\InventoryCategory;
use App\Models\ProductPricingVolume;
use App\Models\ProductType;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use App\Models\SiteTheme;
use App\Services\Company\ColorLogoService;
use App\Services\Company\ThemeService;
use App\Services\Company\AddressService;
use App\Services\Company\HeroTextService;
use App\Services\Company\EmailService;
use App\Services\Company\PhoneService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $this->middleware('permission:settings-category-list', ['only' => ['all_category']]);
        $this->middleware('permission:settings-category-create', ['only' => ['create_category','post_category']]);

        $this->middleware('permission:settings-category-edit', ['only' => ['editCategory','updateCategory']]);
        $this->middleware('permission:settings-category-delete', ['only' => ['deleteCategory']]);

        $this->middleware('permission:settings-logo-create', ['only' => ['color_logo','storeColorLogo']]);
        $this->middleware('permission:settings-theme-create', ['only' => ['theme','storeTheme']]);
        $this->middleware('permission:settings-hero-text-create', ['only' => ['hero_text','storeHeroText']]);

        $this->middleware('permission:settings-address-create', ['only' => ['address','storeAddress']]);
        $this->middleware('permission:settings-email-create', ['only' => ['email','storeEmail']]);
        $this->middleware('permission:settings-phone-create', ['only' => ['phone','storePhone']]);
    }



    public function all_category()
    {
        $expense_category =  ExpenseCategory::where('company_id', app('company_id'))->get();
        return view('company.settings.category.all_category', compact('expense_category'));
    }

    public function create_category()
    {
        return view('company.settings.category.add_category');
    }

    public function create_product_pricing()
    {
        $productTypes = ProductType::where('company_id', app('company_id'))->get();
        return view('company.settings.category.add_product_pricing', compact('productTypes'));
    }

    public function all_product_pricing()
    {
        $productPricingVolumes = ProductPricingVolume::with('productType')
            ->where('company_id', app('company_id'))
            ->get();

        return view('company.settings.category.all_product_pricing', compact('productPricingVolumes'));
    }

    public function post_product_pricing(Request $request)
    {
        // 1. Validate the incoming array data
        $request->validate([
            'name'       => 'required|array',
            'name.*'     => 'required|exists:product_types,id', // Validates against product_types table
            'min_qty'    => 'required|array',
            'min_qty.*'  => 'required|integer|min:1',
            'max_qty'    => 'required|array',
            'max_qty.*'  => 'required|integer|min:1',
            'cost'       => 'required|array',
            'cost.*'     => 'required|numeric|min:0',
        ]);

        // 2. Use a database transaction to ensure all rows save successfully together
        DB::beginTransaction();

        // dd($request->name, $request->min_qty, $request->max_qty, $request->cost);

        try {
            // Loop through one of the arrays using its index keys
            foreach ($request->name as $index => $productTypeId) {
                
                // Create a new catalogue entry for each row added in the view
                $catalogue = new ProductPricingVolume();
                // dd($catalogue);
                
                // Mapping form inputs to table columns
                $catalogue->company_id      = app('company_id'); 
                $catalogue->product_type_id = $productTypeId; 
                $catalogue->min_qty         = $request->min_qty[$index];
                $catalogue->max_qty         = $request->max_qty[$index];
                $catalogue->cost            = $request->cost[$index];
                
                // Optional: Link to a company or brand if needed for context
                // $catalogue->brand_identity = 'YourBrandName'; 

                $catalogue->save();
            }

            DB::commit();

            return redirect()->route('company.settings.category.all_product_pricing')
                             ->with('flash_success', 'Product Pricing Volume saved successfully!');

        } catch (\Exception $e) {
            Log::error('Error saving product pricing: ' . $e->getMessage());
            DB::rollBack();
            
            return redirect()->back()
                             ->withInput()
                             ->with('flash_error', 'Something went wrong. Please try again.');
        }
    }

    public function editProductPricing($id)
    {
        $productPricingVolume = ProductPricingVolume::findOrFail($id);
        $productTypes = ProductType::where('company_id', app('company_id'))->get();
        return view('company.settings.category.edit_product_pricing', compact('productPricingVolume', 'productTypes'));
    }

    public function updateProductPricing(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name'       => 'required|exists:product_types,id',
            'min_qty'    => 'required|integer|min:1',
            'max_qty'    => 'required|integer|min:1',
            'cost'       => 'required|numeric|min:0',
        ]);

        try {
            $productPricingVolume = ProductPricingVolume::findOrFail($id);
            
            // Update the fields with new values from the request
            $productPricingVolume->product_type_id = $request->name;
            $productPricingVolume->min_qty         = $request->min_qty;
            $productPricingVolume->max_qty         = $request->max_qty;
            $productPricingVolume->cost            = $request->cost;

            $productPricingVolume->save();

            return redirect()->route('company.settings.category.all_product_pricing')
                             ->with('flash_success', 'Product Pricing Volume updated successfully!');

        } catch (\Exception $e) {
            Log::error('Error updating product pricing: ' . $e->getMessage());
            
            return redirect()->back()
                             ->withInput()
                             ->with('flash_error', 'Something went wrong. Please try again.');
        }
    }

    public function deleteProductPricing($id)
    {
        try {
            $productPricingVolume = ProductPricingVolume::findOrFail($id);
            $productPricingVolume->delete();

            return redirect()->route('company.settings.category.all_product_pricing')
                             ->with('flash_success', 'Product Pricing Volume deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Error deleting product pricing: ' . $e->getMessage());
            
            return redirect()->back()
                             ->with('flash_error', 'Something went wrong. Please try again.');
        }
    }


    public function post_category()
    {
        try{
            $user = Auth::user();
            //save into locations

            $name                 =  request('name');
            for ($count=0; $count < count($name); $count++) {
                $order_location =  ExpenseCategory::updateOrCreate(
                    [
                        'company_id'    => app('company_id'),
                        'category_name' => $name[$count],
                        'created_by'    => $user->id,
                    ],
                );
            }
            return redirect(route('company.settings.category.all_category'))->with('flash_success','Expense category added successfully');
        }catch(\Exception $th){
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }

    }

    public function editCategory($id){
        $expense_category =  ExpenseCategory::find($id);
        return view('company.settings.category.edit_category', compact('expense_category'));
    }

    public function updateCategory($id){
        try{
            $expense_category =  ExpenseCategory::find($id);
            $expense_category->category_name = request('name');
            $expense_category->save();
            return redirect(route('company.settings.category.all_category'))->with('flash_success','Expense category edited successfully');
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }

    }

    public function deleteCategory($id){
        try{
            $expense_category =  ExpenseCategory::find($id);
            $expense_category->delete();
            return redirect(route('company.settings.category.all_category'))->with('flash_success','Expense category deleted successfully');
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }

    }

    public function all_inventory_category()
    {
        $inventory_category =  InventoryCategory::where('company_id', app('company_id'))->get();
        return view('company.settings.category.all_inventory_category', compact('inventory_category'));
    }

    public function create_inventory_category()
    {
        return view('company.settings.category.add_inventory_category');
    }

    public function post_inventory_category()
    {
        try{
            $user = Auth::user();
            //save into locations

            $name                 =  request('name');
            for ($count=0; $count < count($name); $count++) {
                $order_location =  InventoryCategory::updateOrCreate(
                    [
                        'company_id'    => app('company_id'),
                        'category_name' => $name[$count],
                        'created_by'    => $user->id,
                    ],
                );
            }
            return redirect(route('company.settings.category.all_inventory_category'))->with('flash_success','Inventory category added successfully');
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }

    }

     public function editInventoryCategory($id){
        $inventory_category =  InventoryCategory::find($id);
        return view('company.settings.category.edit_inventory_category', compact('inventory_category'));
    }

    public function updateInventoryCategory($id){
        try{
            $inventory_category =  InventoryCategory::find($id);
            $inventory_category->category_name = request('name');
            $inventory_category->save();
            return redirect(route('company.settings.category.all_inventory_category'))->with('flash_success','Inventory category edited successfully');
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }

    }

    public function deleteInventoryCategory($id){
        try{
            $inventory_category =  InventoryCategory::find($id);
            $inventory_category->delete();
            return redirect(route('company.settings.category.all_inventory_category'))->with('flash_success','Inventory category deleted successfully');
        }catch(\Exception $th){
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }

    }

    private function siteDetails (){
        $user = Auth::user();
        return SiteSetting::where('company_id', $user->company_id)->first();
    }

    public function color_logo(){
        return view('company.settings.site.color_logo');
    }

    public function theme(){
        $themes = SiteTheme::all();
        $site_theme = $this->siteDetails();
        return view('company.settings.site.theme', compact('themes','site_theme'));
    }

    public function storeTheme(Request $request, ThemeService $themeservice){
        return $themeservice->postTheme($request);
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
