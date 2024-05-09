<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpenseCategory;
use App\Models\User;
use App\Models\SiteTheme;
use App\Models\SubscriptionPlan;
use App\Models\BankAccount;

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



    public function list_theme()
    {
        $themes  = SiteTheme::all();
        return view('admin.settings.theme.list', compact('themes'));
    }

    public function create_theme()
    {
        return view('admin.settings.theme.add');
    }

    public function store_theme(Request $request)
    {
        $user = Auth::user();
        try{
            $theme = new SiteTheme();
            $theme->name          = request('name');
            $theme->color      = request('color');

            $theme->save();
            return redirect(route('admin.settings.theme.list_theme'))->with('flash_success','Theme saved successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    public function edit_theme($id)
    {
        $theme  = SiteTheme::find($id);
        return view('admin.settings.theme.edit', compact('theme'));
    }

    public function update_theme($id)
    {

        try{
            $theme  = SiteTheme::find($id);
            $theme->name          = request('name');
            $theme->color      = request('color');

            $theme->save();
            return redirect(route('admin.settings.theme.list_theme'))->with('flash_success','Theme updated successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }


    public function delete_theme($id)
    {
        try{
            $theme  = SiteTheme::find($id);

            $theme->delete();
            return redirect(route('admin.settings.theme.list_theme'))->with('flash_success','Theme deleted successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }


    public function list_subscription()
    {
        $subs  = SubscriptionPlan::all();
        return view('admin.settings.subscription.list', compact('subs'));
    }

    public function create_subscription()
    {
        return view('admin.settings.subscription.add');
    }

    public function store_subscription(Request $request)
    {
        $user = Auth::user();
         try{
            $sub = new SubscriptionPlan();
            $sub->name          = request('name');
            $sub->amount      = request('amount');

            $sub->save();
            return redirect(route('admin.settings.subscription.list_subscription'))->with('flash_success','Subscription saved successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    public function edit_subscription($id)
    {
        $sub =      SubscriptionPlan::find($id);
        return view('admin.settings.subscription.edit', compact('sub'));
    }

    public function update_subscription($id)
    {
        try{
            $sub =      SubscriptionPlan::find($id);
            $sub->name        = request('name');
            $sub->amount      = request('amount');

            $sub->save();
            return redirect(route('admin.settings.subscription.list_subscription'))->with('flash_success','Subscription updated successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    public function delete_subscription($id)
    {
        try{
            $sub  = SubscriptionPlan::find($id);

            $sub->delete();
            return redirect(route('admin.settings.subscription.list_subscription'))->with('flash_success','Subscription deleted successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    public function list_subscription()
    {
        $subs  = SubscriptionPlan::all();
        return view('admin.settings.admin_role', compact('subs'));
    }

    public function list_bankaccount()
    {
        $banks  = BankAccount::all();
        return view('admin.settings.bank.list', compact('banks'));
    }

    public function create_bankaccount()
    {
        return view('admin.settings.bank.add');
    }

    public function store_bankaccount(Request $request)
    {
        $user = Auth::user();
         try{
            $bank = new BankAccount();
            $bank->bank_name        = request('bank_name');
            $bank->account_no       = request('account_no');
            $bank->account_name      = request('account_name');

            $bank->save();
            return redirect(route('admin.settings.bank.list_bankaccount'))->with('flash_success','Bank Details saved successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    public function edit_bankaccount($id)
    {
        $bank =      BankAccount::find($id);
        return view('admin.settings.bank.edit', compact('bank'));
    }

    public function update_bankaccount($id)
    {
        try{
            $bank =      BankAccount::find($id);
            $bank->bank_name        = request('bank_name');
            $bank->account_no       = request('account_no');
            $bank->account_name      = request('account_name');

            $bank->save();
            return redirect(route('admin.settings.bank.list_bankaccount'))->with('flash_success','Bank Details updated successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }


    public function delete_bankaccount($id)
    {
        try{
            $bank  = BankAccount::find($id);

            $bank->delete();
            return redirect(route('admin.settings.bank.list_bankaccount'))->with('flash_success','Bnak Details deleted successfully');
        }catch (\Throwable $th){
            //ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

}
