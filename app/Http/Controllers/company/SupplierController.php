<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\ErrorLog;
use Illuminate\Support\Facades\Auth;
class SupplierController extends Controller
{

    public  $startDate;
    public $endDate;

    public function __construct()
    {
        $this->middleware('auth');


        $this->middleware('permission:supplier-create', ['only' => ['create','store']]);

        $this->middleware('permission:supplier-list', ['only' => ['index']]);
        $this->middleware('permission:supplier-view', ['only' => ['show']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);

        $this->startDate  = request('date_from').' 23:59:59';
        $this->endDate    = request('date_to').' 23:59:59';
    }
    public function index(Request $request = null)
    {

        if(request()->date_to && request()->date_from){
            $suppliers = Supplier::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        }else{
            $suppliers = Supplier::all();
        }


        return view('company.suppliers.all_suppliers', compact('suppliers'));
    }

    public function create()
    {
        return view('company.suppliers.add_supplier');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'company_name' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            // 'email' => 'stemaring',
            'phone' => 'required|string',
            'address' => 'required|string',
            // Add more rules as needed
        ], [
            'company_name.required' => 'Please enter supplier company name.',
            'firstname.required' => 'Please enter supplier  firstname.',
            'lastname.required' => 'Please enter supplier  lastname.',
            // 'email.required' => 'Please enter customer email address.',
            // 'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter supplier phone number.',
            'address.required' => 'Please enter supplier address.',
        ]);
        try{
            $supplier = new Supplier();
            $supplier->company_id   = app('company_id');
            $supplier->company_name = request('company_name');
            $supplier->firstname    = request('firstname');
            $supplier->lastname     = request('lastname');
            $supplier->email        = request('email');
            $supplier->phone        = request('phone');
            $supplier->address      = request('address');
            $supplier->created_by   = $user->id;

            $supplier->save();
            return back()->with("flash_success","Supplier saved successfully");

        }catch (\Throwable $th){
            ErrorLog::log('supplier', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);
        return view('company.suppliers.view_supplier', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('company.suppliers.edit_supplier', compact('supplier'));
    }
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'company_name' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            // Add more rules as needed
        ], [
            'company_name.required' => 'Please enter supplier company name.',
            'firstname.required' => 'Please enter supplier  firstname.',
            'lastname.required' => 'Please enter supplier  lastname.',
            'phone.required' => 'Please enter supplier phone number.',
            'address.required' => 'Please enter supplier address.',
        ]);

        try{
            $supplier = Supplier::find($id);
            $supplier->company_name = request('company_name');
            $supplier->firstname    = request('firstname');
            $supplier->lastname     = request('lastname');
            $supplier->email        = request('email');
            $supplier->phone        = request('phone');
            $supplier->address      = request('address');
            $supplier->updated_by   = $user->id;

            $supplier->update();
            return back()->with("flash_success","Supplier saved successfully");

        }catch (\Throwable $th){
            ErrorLog::log('supplier', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }
    public function destroy($id)
    {
        $supplier = Supplier::find($id)->delete();
        return redirect(route('company.suppliers.all_suppliers'))->with('flash_success','User has been deleted');
    }
}
