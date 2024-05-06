<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\ErrorLog;
use Illuminate\Support\Facades\Auth;

class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:requisition-list', ['only' => ['index']]);
        $this->middleware('permission:requisition-create', ['only' => ['create','store']]);

        $this->middleware('permission:requisition-view', ['only' => ['view']]);
        $this->middleware('permission:requisition-edit', ['only' => ['edit','update']]);

    }
    public function index()
    {
        $requisitions = Requisition::all();
        return view('company.finance.requisitions.all_requisitions', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.finance.requisitions.add_requisition');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'item' => 'required|string',
            'quantity' => 'required|string',
            'cost' => 'required|string',
            'description' => 'required|string',

        ], [
            'item.required' => 'Please enter Item.',
            'quantity.required' => 'Please enter Quantity.',
            'cost.required' => 'Please enter Cost.',
            'description.required' => 'Please enter Description.',
        ]);
        try{
            $requisition = new Requisition();
            $requisition->item          = request('item');
            $requisition->quantity      = request('quantity');
            $requisition->cost          = request('cost');
            $requisition->description   = request('description');
            $requisition->created_by    = $user->id;

            $requisition->save();
            return redirect(route('company.finance.requisitions.all_requisitions'))->with('flash_success','Requisition saved successfully');
        }catch (\Throwable $th){
            ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }

    public function edit($id)
    {
        $req = Requisition::find($id);
        return view('company.requisitions.edit_requisition', compact('req'));
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
        $user = Auth::user();
        $validatedData = $request->validate([
            'item' => 'required|string',
            'quantity' => 'required|string',
            'cost' => 'required|string',
            'description' => 'required|string',

        ], [
            'item.required' => 'Please enter Item.',
            'quantity.required' => 'Please enter Quantity.',
            'cost.required' => 'Please enter Cost.',
            'description.required' => 'Please enter Description.',
        ]);
        try{
            $requisition =  Requisition::find($id);
            $requisition->item          = request('item');
            $requisition->quantity      = request('quantity');
            $requisition->cost          = request('cost');
            $requisition->description   = request('description');
            $requisition->created_by    = $user->id;

            $requisition->save();
            return redirect(route('company.finance.requisitions.all_requisitions'))->with('flash_success','Requisition updated successfully');
        }catch (\Throwable $th){
            ErrorLog::log('customer', '__METHOD__', $th->getMessage()); //log error
            return back()->with("flash_error","There is an error processing this request");
        }
    }
}
