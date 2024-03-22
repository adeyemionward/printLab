<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Http\Requests\CustomerRequest;
use App\Models\User;
use App\Models\ErrorLog;
use Illuminate\Support\Facades\Hash;
use Mail;
use Barryvdh\DomPDF\Facade\Pdf;
class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function find_customer ($user_id){
       return $customer = User::find($user_id);
    }

    public function index()
    {
        $customers = User::where('user_type', User::MEMBER)->get();
        return view('dashboard.admin.parties.customer.index', compact('customers'));
    }
    public function create()
    {
        return view('dashboard.admin.parties.customer.add');
    }

    public function store(CustomerRequest $request, CustomerService $customerservice)
    {
        return $customerservice->postCustomer($request);
    }

    public function view($id)
    {
        $customer = $this->find_customer($id);
        return view('dashboard.admin.parties.customer.view', compact('customer'));
    }


    public function destroy($id)
    {
        $customer = User::find($id);
        $customer->status = 'deactivated';
        $customer->save();
        return redirect(route('customers.all_customers'))->with('flash_success','Customer has been deactivated');
    }
}
