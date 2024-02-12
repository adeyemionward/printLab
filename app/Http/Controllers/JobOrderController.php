<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\JobOrder;
use App\Models\HigherNoteBook;
use App\Models\TwentyLeavesBook;
use App\Models\FortyLeavesBook;
use App\Models\EightyLeavesBook;
use App\Models\SmallInvoice;
use App\Models\Brochure;
use App\Models\Flyer;
use App\Models\BusinessCard;
use App\Models\Notepad;
use App\Models\Booklet;
use App\Models\Sticker;
use App\Models\JobOrderTracking;
use App\Models\JobLocation;
use App\Models\OrderApprovedDesign;
use App\Models\JobPaymentHistory;
use App\Repository\ServiceOrderRepository;
use App\Repository\SmallInvoiceRepository;
use App\Repository\StickersRepository;
use App\Repository\NoteBookRepository;
use App\Repository\NotePadRepository;
use App\Repository\BookletRepository;
use App\Repository\FlyerRepository;
use App\Repository\BrochureRepository;
use App\Repository\BusinessCardRepository;
use App\Repository\EnvelopeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\CustomerOrderReceipt;
use Mail;
use App\Models\ErrorLog;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\FilterOrdersByDateTrait;
class JobOrderController extends Controller
{
    use FilterOrdersByDateTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function JobOrderQuery (){
        return $jobQuery =  JobOrder::where('order_type','internal')->where('cart_order_status',JobOrder::ORDER_COMPLETED);
    }

    private function filterOrdersByDateInternal(){
        return $this->filterOrdersByDate()->where('order_type','internal');
    }

    private function postNoteBook(Request $request, NoteBookRepository $noteBookRepository){

        $result = $noteBookRepository->noteBookOrder($request->all());

        if ($result['success']) {
            // creation was successful
            $redirectResponse = redirect(route('customers.customer_cart', $request->customer_id))->with('flash_success','Product added to Cart');
        } else {
            // creation failed
            $redirectResponse = redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }
        return $redirectResponse;
    }


    public function index()
    {
        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDateInternal();
        }else{
            $job_orders = $this->JobOrderQuery()->get();
        }

        return view('job_order/all_orders', compact('job_orders'));
    }

    public function changeJobStatus(Request $request, $job_title, $id){
        $job_order =  JobOrder::find($id);
        $job_order->status =  request('order_status');
        $job_order->updated_by =  Auth::user()->id;
        $order_date = date('Y-m-d');

        if(request('order_status') == 'Designed'){
            $job_tracking =  JobOrderTracking::where('job_order_id',$id)->first();
            $job_tracking->designed_status   = 1;
            $job_tracking->designed_date     = $order_date;
            $job_tracking->update();
        }

        if(request('order_status') == 'Proof Read'){
            $job_tracking =  JobOrderTracking::where('job_order_id',$id)->first();
            $job_tracking->proof_read_status   = 1;
            $job_tracking->proof_read_date     = $order_date;
            $job_tracking->update();
        }

        if(request('order_status') == 'Customer Approved'){
            $job_tracking =  JobOrderTracking::where('job_order_id',$id)->first();
            $job_tracking->customer_approved_status   = 1;
            $job_tracking->customer_approved_date     = $order_date;
            $job_tracking->update();
        }

        if(request('order_status') == 'Prepressed'){
            $job_tracking =  JobOrderTracking::where('job_order_id',$id)->first();
            $job_tracking->prepressed_status   = 1;
            $job_tracking->prepressed_date     = $order_date;
            $job_tracking->update();
        }

        if(request('order_status') == 'Printed'){
            $job_tracking =  JobOrderTracking::where('job_order_id',$id)->first();
            $job_tracking->printed_status   = 1;
            $job_tracking->printed_date     = $order_date;
            $job_tracking->update();
        }

        if(request('order_status') == 'Binded'){
            $job_tracking =  JobOrderTracking::where('job_order_id',$id)->first();
            $job_tracking->binded_status   = 1;
            $job_tracking->binded_date     = $order_date;
            $job_tracking->update();
        }

        if(request('order_status') == 'Completed'){
            $job_tracking =  JobOrderTracking::where('job_order_id',$id)->first();
            $job_tracking->completed_status   = 1;
            $job_tracking->completed_date     = $order_date;
            $job_tracking->update();
        }

        if(request('order_status') == 'Delivered'){
            $job_tracking =  JobOrderTracking::where('job_order_id',$id)->first();
            $job_tracking->delivered_status   = 1;
            $job_tracking->delivered_date     = $order_date;
            $job_tracking->update();
        }

        $job_order->update();
        return back()->with("flash_success","Order status changed successfully");
    }


    public function uploadApprovedDesign(Request $request, $job_title, $id){
        $user = Auth::user();
        if($approved_design_pdf = $request->file('design_file')){
            $name = $approved_design_pdf->hashName(); // Generate a unique, random name...
            $path = $approved_design_pdf->store('public/pdf');
            $approved_design =  OrderApprovedDesign::updateOrCreate(
                [
                    'job_order_id'  => $id,
                ],
                [
                    'job_order_id'  => $id,
                    'design_name'   => $name,
                    'created_by'    => $user->id
                ],
            );
        }
        return back()->with("flash_success","Design Uploaded successfully");
    }

    public function orderInvoicePdf($order_no){

        $orderDetails =  JobOrder::where('order_no', $order_no)->get();
        $order1 =  JobOrder::where('order_no', $order_no)->first();

        $pdf = PDF::loadView('job_order.order_invoice_pdf',compact('orderDetails','order1'));
        return $pdf->stream('order_invoice.pdf');
    }

    public function updateJobPayment(Request $request, $job_title, $id){
        $user = Auth::user();
        $order_date = date('Y-m-d');
        $amount_paid                =  request('amount_paid');
        $payment_type               =  request('payment_type');

        $job_order =  JobOrder::find($id);

        $job_pay = new JobPaymentHistory();
        $job_pay->job_order_id    = $id;
        $job_pay->user_id     = $job_order->user_id;
        $job_pay->amount          = $amount_paid;
        $job_pay->payment_type    = $payment_type;
        $job_pay->payment_date    = $order_date;
        $job_pay->created_by      = $user->id;
        $job_pay->save();

        return back()->with("flash_success","Order Payment updated successfully");
    }

    public function delete_job_order(Request $request, $id){
        $job_orders =  JobOrder::all();
        $job_order =  JobOrder::find($id);
        $job_order->delete();
        return redirect(route('job_order.all_orders'))->with('flash_success','Job Order deleted successfully');
    }

    public function view_order($job_title, $id){
        $approved_design  = OrderApprovedDesign::where('job_order_id',$id)->first();
        $job_order =  JobOrder::find($id);
        $job_order_pay  = JobPaymentHistory::select(DB::raw('SUM(amount) as amount'))
            ->where('job_order_id',$id)
            ->first();
        return view('job_order.view_order', compact('job_order','job_order_pay','approved_design'));
    }

    public function track_job_order($job_title,$id){
        $approved_design  = OrderApprovedDesign::where('job_order_id',$id)->first();
        $job_order =  JobOrder::find($id);
        $job_order_pay  = JobPaymentHistory::select(DB::raw('SUM(amount) as amount'))
            ->where('job_order_id',$id)
            ->first();
        $job_order_track =  JobOrderTracking::where('job_order_id',$id)->first();
        return view('job_order.track_order', compact('job_order','job_order_track','job_order_pay','approved_design'));
    }

    public function transaction_history($job_title,$id){
        $approved_design  = OrderApprovedDesign::where('job_order_id',$id)->first();
        $job_order =  JobOrder::find($id);
        $job_pay_history =  JobPaymentHistory::where('job_order_id',$id)->get();
        return view('job_order.transaction_history', compact('job_order','job_pay_history','approved_design'));
    }

    public function higher_education()
    {
        $customers =  User::where('user_type',User::CUSTOMER)->get();
        $locations =  JobLocation::getLocations();
        return view('job_order.higher_education', compact('customers','locations'));
    }

    public function post_higher_education(Request $request)
    {
        // Call the function to postnotebook
        $response = $this->postNoteBook($request);
        return $response;
    }


    public function twenty_leaves()
    {
        $customers =  User::where('user_type',2)->get();
        $locations =  JobLocation::select('id','city')->get();
        return view('job_order.20_leaves_book', compact('customers','locations'));

    }

    public function post_twenty_leaves(Request $request)
    {
        // Call the function to postnotebook
        $response = $this->postNoteBook($request);
        return $response;
    }

    public function edit_twenty_leaves($job_title, $id){
        $job_order =  JobOrder::find($id);
        $customers =  User::where('user_type',2)->get();
        return view('job_order.edit_twenty_leaves', compact('job_order','customers'));
    }

    public function forty_leaves()
    {
        $customers =  User::where('user_type',2)->get();
        $locations =  JobLocation::getLocations();
        return view('job_order.40_leaves_book', compact('customers','locations'));
    }

    public function post_forty_leaves(Request $request)
    {
        // Call the function to postnotebook
        $response = $this->postNoteBook($request);
        return $response;
    }

    public function eighty_leaves()
    {
        $customers =  User::where('user_type',User::CUSTOMER)->get();
        $locations =  JobLocation::getLocations();
        return view('job_order.80_leaves_book', compact('customers','locations'));
    }

    public function post_eighty_leaves(Request $request)
    {
        // Call the function to postnotebook
        $response = $this->postNoteBook($request);
        return $response;
    }

    public function service_order()
    {
        $customers  =  User::getCustomers();
        $locations  =  JobLocation::getLocations();

        return view('job_order.service_order', compact('customers','locations'));
    }


    public function post_service_order(Request $request, ServiceOrderRepository $serviceOrderRepository)
    {
        $result = $serviceOrderRepository->serviceOrder($request->all());

        if ($result['success']) {
            // creation was successful
            return redirect(route('customers.customer_cart', $request->customer_id))->with('flash_success','Product added to Cart');
        } else {
            // creation failed
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }
    }

    public function booklets()
    {
        $customers  =  User::getCustomers();
        $locations  =  JobLocation::getLocations();
        return view('job_order.booklets', compact('customers', 'locations'));
    }


    public function post_booklets(Request $request, BookletRepository $bookletRepository)
    {
        $response = $bookletRepository->postBooklet($request);
        return $response;
    }

    public function bronchures()
    {
        $customers  =  User::getCustomers();
        $locations  =  JobLocation::getLocations();
        return view('job_order.bronchures', compact('customers','locations'));
    }

    public function post_bronchures(Request $request, BrochureRepository $brochureRepository)
    {
        $response = $brochureRepository->postBrochure($request);
        return $response;
    }

    public function business_cards()
    {
        $customers  =  User::getCustomers();
        $locations  =  JobLocation::getLocations();
        return view('job_order.business_cards', compact('customers','locations'));
    }

    public function post_business_cards(Request $request, BusinessCardRepository $businessCardRepository)
    {
        $response = $businessCardRepository->postBusinessCard($request);
        return $response;
    }

    public function envelopes()
    {
        $customers = User::getCustomers();
        $locations =  JobLocation::getLocations();
        return view('job_order.envelopes', compact('customers','locations'));
    }

    public function post_envelopes(Request $request, EnvelopeRepository $envelopeRepository)
    {
        $response = $envelopeRepository->postenvelope($request);
        return $response;
    }

    public function flyers()
    {
        $customers  =  User::getCustomers();
        $locations  =  JobLocation::getLocations();
        return view('job_order.flyers', compact('customers', 'locations'));
    }

    public function post_flyers(Request $request, FlyerRepository $flyerRepository)
    {
        $response = $flyerRepository->postFlyer($request);
        return $response;
    }

    public function notepads()
    {
        $customers = User::getCustomers();
        $locations =  JobLocation::getLocations();
        return view('job_order.notepads', compact('customers','locations'));
    }

    public function post_notepads(Request $request, NotePadRepository $notePadRepository)
    {
        $response = $notePadRepository->postNotePadOrder($request);
        return $response;
    }

    public function small_invoice()
    {
        $customers =  $customers = User::getCustomers();
        $locations =  JobLocation::getLocations();
        return view('job_order.small_invoice', compact('customers','locations'));
    }

    public function post_small_invoice(Request $request, SmallInvoiceRepository $smallInvoiceRepository)
    {
        $response = $smallInvoiceRepository->postSmallInvoiceOrder($request);
        return $response;
    }

    public function stickers()
    {
        $customers =  $customers = User::getCustomers();
        $locations =  JobLocation::getLocations();
        return view('job_order.stickers', compact('customers','locations'));
    }

    public function post_stickers(Request $request, StickersRepository $stickersRepository)
    {
        $response = $stickersRepository->postStickersOrder($request);
        return $response;
    }

    public function work_order_templates()
    {
        return view('job_order.work_order_templates');
    }


    public function edit_order($job_title, $id){
        $approved_design  = OrderApprovedDesign::where('job_order_id',$id)->first();
        $job_order =  JobOrder::find($id);
        $customers =  User::where('user_type',2)->get();
        $locations =  JobLocation::select('id','city')->get();
        return view('job_order/edit_order', compact('job_order','customers','locations','approved_design'));
    }

    public function update_order(Request $request, $job_title, $id){
        $user = Auth::user();
        $job_order =  JobOrder::find($id);
        $customers =  User::where('user_type',2)->get();
        //dd(request()->job_title);
        if(request()->job_title == 'Eighty_Leaves'){
            $user = Auth::user();

            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $proof_needed               =  request('proof_needed');
            $total_cost                 =  request('total_cost');
            $location                   =  request('location');


            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Eighty Leaves';
            $job_order->quantity        = $quantity;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->production_days = $production_time;
            $job_order->thickness       = $thickness;
            $job_order->proof_needed    = $proof_needed;
            $job_order->total_cost      = $total_cost;
            $job_order->job_location_id        = $location;
            $job_order->updated_by      = $user->id;
            $job_order->save();

            return redirect(route('job_order.view_order',['Eighty_Leaves',$id]))->with('flash_success','Eighty Leaves Book order updated successfully');


        }elseif(request()->job_title == 'Higher_NoteBook'){

            $order_date = date('Y-m-d');
            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $proof_needed               =  request('proof_needed');
            $total_cost                 =  request('total_cost');
            $location                   =  request('location');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Higher NoteBook';
            $job_order->quantity        = $quantity;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->production_days = $production_time;
            $job_order->thickness = $thickness;
            $job_order->proof_needed    = $proof_needed;
            //$job_order->order_date     = $order_date;
            $job_order->total_cost      = $total_cost;

            $job_order->job_location_id        = $location;
            $job_order->updated_by      = $user->id;
            $job_order->save();
            return redirect(route('job_order.view_order',['Higher_NoteBook',$id]))->with('flash_success','Higher Note Book order updated successfully');

        }elseif(request()->job_title == 'Twenty_Leaves'){
            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness           =  request('thickness');
            $proof_needed               =  request('proof_needed');
            $total_cost                 =  request('total_cost');
            $location                   =  request('location');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Twenty Leaves';
            $job_order->quantity        = $quantity;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->production_days = $production_time;
            $job_order->thickness      = $thickness;
            $job_order->proof_needed    = $proof_needed;
            //$job_order->order_date     = $order_date;
            $job_order->total_cost      = $total_cost;
            $job_order->job_location_id        = $location;
            $job_order->updated_by      = $user->id;
            $job_order->save();
            return redirect(route('job_order.view_order',['Twenty_Leaves',$id]))->with('flash_success','Twenty Leaves Book order updated successfully');
        }elseif(request()->job_title == 'Forty_Leaves'){

            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $thickness                  =  request('thickness');
            $proof_needed               =  request('proof_needed');
            $total_cost                 =  request('total_cost');
            $location                   =  request('location');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Forty Leaves';
            $job_order->quantity        = $quantity;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->production_days = $production_time;
            $job_order->thickness      = $thickness;
            $job_order->proof_needed    = $proof_needed;
            $job_order->total_cost      = $total_cost;
            $job_order->job_location_id        = $location;
            //$job_order->order_date     = $order_date;
            $job_order->updated_by      = $user->id;
            $job_order->save();

            return redirect(route('job_order.view_order',['Forty_Leaves',$id]))->with('flash_success','Forty Leaves Book order updated successfully');

        }elseif(request()->job_title == 'Small_Invoice'){


            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $size                       =  request('size');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $back_sided_print           =  request('back_sided_print');
            $proof_needed               =  request('proof_needed');
            $hole_drilling              =  request('hole_drilling');
            $perforating                =  request('perforating');
            $edge_to_glue               =  request('edge_to_glue');
            $books_with_covers          =  request('books_with_covers');
            $numbering_needed           =  request('numbering_needed');
            $start_number               =  request('start_number');
            $shrink_wrap                =  request('shrink_wrap');
            $total_cost                 =  request('total_cost');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Small Invoice';
            $job_order->quantity        = $quantity;
            $job_order->size            = $size;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->production_days = $production_time;
            $job_order->back_sided_print      = $back_sided_print;
            $job_order->proof_needed    = $proof_needed;
            $job_order->hole_drilling    = $hole_drilling;
            $job_order->perforating    = $perforating;
            $job_order->edge_to_glue    = $edge_to_glue;
            $job_order->books_with_covers    = $books_with_covers;
            $job_order->numbering_needed    = $numbering_needed;
            $job_order->start_number    = $start_number;
            $job_order->shrink_wrap    = $shrink_wrap;
            $job_order->total_cost      = $total_cost;
           // $job_order->order_date     = $order_date;
            $job_order->updated_by      = $user->id;
            $job_order->save();
            return redirect(route('job_order.view_order',['Small_Invoice',$id]))->with('flash_success','Small Invoice order updated successfully');
        }elseif(request()->job_title == 'Bronchures'){
            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $size                       =  request('size');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $folding                    =  request('folding');
            $production_time            =  request('production_time');
            $back_sided_print           =  request('back_sided_print');
            $proof_needed               =  request('proof_needed');
            $total_cost                 =  request('total_cost');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Bronchures';
            $job_order->quantity        = $quantity;
            $job_order->size            = $size;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->folding         = $folding;
            $job_order->production_days = $production_time;
            $job_order->back_sided_print    = $back_sided_print;
            $job_order->proof_needed    = $proof_needed;
            $job_order->total_cost      = $total_cost;
            $job_order->updated_by      = $user->id;
            $job_order->save();
            return redirect(route('job_order.view_order',['Bronchures',$id]))->with('flash_success','Bronchures order updated successfully');

        }elseif(request()->job_title == 'Flyer'){
            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $size                       =  request('size');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $cut_to_size                =  request('cut_to_size');
            $production_time            =  request('production_time');
            $back_sided_print           =  request('back_sided_print');
            $proof_needed               =  request('proof_needed');
            $total_cost                 =  request('total_cost');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Flyer';
            $job_order->quantity        = $quantity;
            $job_order->size            = $size;
            $job_order->ink             = $ink;
            $job_order->cut_to_size     = $cut_to_size;
            $job_order->paper_type      = $paper_type;
            $job_order->production_days = $production_time;
            $job_order->back_sided_print    = $back_sided_print;
            $job_order->proof_needed    = $proof_needed;
            $job_order->total_cost      = $total_cost;
            $job_order->updated_by      = $user->id;
            $job_order->save();
            return redirect(route('job_order.view_order',['Flyer',$id]))->with('flash_success','Flyer order updated successfully');

        }elseif(request()->job_title == 'Business_Cards'){


        $customer_id                =  request('customer_id');
        $quantity                   =  request('quantity');
        $size                       =  request('size');
        $ink                        =  request('ink');
        $paper_type                 =  request('paper_type');
        $production_time            =  request('production_time');
        $back_sided_print           =  request('back_sided_print');
        $proof_needed               =  request('proof_needed');
        $total_cost                 =  request('total_cost');

        //save to job
        $job_order =  JobOrder::find($id);
        $job_order->user_id     = $customer_id;
        $job_order->job_order_name  = 'Business Cards';
        $job_order->quantity        = $quantity;
        $job_order->size            = $size;
        $job_order->ink             = $ink;
        $job_order->paper_type      = $paper_type;
        $job_order->production_days = $production_time;
        $job_order->back_sided_print    = $back_sided_print;
        $job_order->proof_needed    = $proof_needed;
        $job_order->total_cost      = $total_cost;
        $job_order->updated_by      = $user->id;
        $job_order->save();
        return redirect(route('job_order.view_order',['Business_Cards',$id]))->with('flash_success','Business_Cards order updated successfully');

        }elseif(request()->job_title == 'Envelopes'){
            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $size                       =  request('size');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $back_sided_print           =  request('back_sided_print');
            $proof_needed               =  request('proof_needed');
            $total_cost                 =  request('total_cost');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Envelopes';
            $job_order->quantity        = $quantity;
            $job_order->size            = $size;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->production_days = $production_time;
            $job_order->back_sided_print    = $back_sided_print;
            $job_order->proof_needed    = $proof_needed;
            $job_order->total_cost      = $total_cost;
            $job_order->updated_by      = $user->id;
            $job_order->save();

            return redirect(route('job_order.view_order',['Envelopes',$id]))->with('flash_success','Envelopes order updated successfully');

        }elseif(request()->job_title == 'Notepads'){

            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $size                       =  request('size');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $page_count                 =  request('page_count');
            $production_time            =  request('production_time');
            $back_sided_print           =  request('back_sided_print');
            $perforating                =  request('perforating');
            $proof_needed               =  request('proof_needed');
            $hole_drilling              =  request('hole_drilling');
            $cut_to_size                =  request('cut_to_size');
            $books_with_cover           =  request('books_with_cover');
            $shrink_wrap                =  request('shrink_wrap');
            $numbering_needed           =  request('numbering_needed');
            $start_number               =  request('start_number');
            $total_cost                 =  request('total_cost');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Notepads';
            $job_order->quantity        = $quantity;
            $job_order->size            = $size;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->page_count      = $page_count;
            $job_order->production_days = $production_time;
            $job_order->perforating = $perforating;
            $job_order->back_sided_print    = $back_sided_print;
            $job_order->proof_needed    = $proof_needed;
            $job_order->hole_drilling   = $hole_drilling;
            $job_order->cut_to_size     = $cut_to_size;
            $job_order->books_with_covers     = $books_with_cover;
            $job_order->shrink_wrap     = $shrink_wrap;
            $job_order->numbering_needed     = $numbering_needed;
            $job_order->start_number     = $start_number;
            $job_order->total_cost      = $total_cost;
            $job_order->updated_by      = $user->id;
            $job_order->save();

            return redirect(route('job_order.view_order',['Notepads',$id]))->with('flash_success','Notepads order updated successfully');

        }elseif(request()->job_title == 'Stickers'){
            $customer_id                =  request('customer_id');
            $quantity                   =  request('quantity');
            $size                       =  request('size');
            $ink                        =  request('ink');
            $paper_type                 =  request('paper_type');
            $production_time            =  request('production_time');
            $proof_needed               =  request('proof_needed');
            $total_cost                 =  request('total_cost');

            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id     = $customer_id;
            $job_order->job_order_name  = 'Stickers';
            $job_order->quantity        = $quantity;
            $job_order->size            = $size;
            $job_order->ink             = $ink;
            $job_order->paper_type      = $paper_type;
            $job_order->production_days = $production_time;
            $job_order->proof_needed    = $proof_needed;
            $job_order->total_cost      = $total_cost;
            $job_order->updated_by      = $user->id;
            $job_order->save();
            return redirect(route('job_order.view_order',['Stickers',$id]))->with('flash_success','Stickers order updated successfully');

        }

        //return back()->with("flash_success","Order updated successfully");

    }

    public function pending (){
        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDateInternal()->where('status','Pending')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Pending')->get();
        }
        return view('job_order.status.pending', compact('job_orders'));
    }



    public function designed (){

        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDateInternal()->where('status','Designed')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Designed')->get();
        }
        return view('job_order.status.designed', compact('job_orders'));
    }

    public function prepressed (){
        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDate()->where('status','Prepressed')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Prepressed')->get();
        }
        return view('job_order.status.prepressed', compact('job_orders'));
    }

    public function proof_read (){
        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDate()->where('status','Proof Read')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Proof Read')->get();
        }
        return view('job_order.status.proof_read', compact('job_orders'));
    }

    public function approved (){
        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDate()->where('status','Customer Approved')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Customer Approved')->get();
        }
        return view('job_order.status.customer_approved', compact('job_orders'));
    }

    public function printed (){
        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDate()->where('status','Printed')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Printed')->get();
        }

        return view('job_order.status.printed', compact('job_orders'));
    }

    public function binded (){
        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDate()->where('status','Binded')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Binded')->get();
        }

        return view('job_order.status.binded', compact('job_orders'));
    }

    public function completed (){
        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDate()->where('status','Completed')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Completed')->get();
        }
        return view('job_order.status.completed', compact('job_orders'));
    }

    public function delivered (){

        if(request()->date_to && request()->date_from){
            $job_orders = $this->filterOrdersByDate()->where('status','Delivered')->get();
        }else{
            $job_orders =   $this->JobOrderQuery()->where('status','Delivered')->get();
        }
        return view('job_order.status.delivered', compact('job_orders'));
    }

    public function all_location(){
        $location =  JobLocation::all();
        return view('job_order.location.all_locations',compact('location'));
    }

    public function add_location(){
        return view('job_order.location.add_locations');
    }

    public function post_location(){
        $user = Auth::user();
        //save into locations

        $city                 =  request('city');
        $state                 =  request('state');
        for ($count=0; $count < count($city); $count++) {
            $order_location =  JobLocation::updateOrCreate(
                [
                    'city'          => $city[$count],
                    'state'         => $state[$count],
                    'created_by'    => $user->id,
                ],
            );
        }
        return redirect(route('job_order.location.all_locations'))->with('flash_success','Order Location saved successfully');

    }

    public function view_location($id){
        $location =  JobLocation::find($id);
        return view('job_order.location.view_location', compact('location'));
    }

    public function edit_location($id){
        $location =  JobLocation::find($id);
        return view('job_order.location.edit_location', compact('location'));
    }

    public function update_location($id){
        $user = Auth::user();
        $location =  JobLocation::find($id);

        $city                =  request('city');
        $state               =  request('state');

        $order_location =  JobLocation::updateOrCreate(
            [
                'id'          => $location->id
            ],
            [
                'city'          => $city,
                'state'         => $state,
                'updated_by'    => $user->id,
            ],
        );
        return redirect(route('job_order.location.all_locations'))->with('flash_success','Order Location updated successfully');
    }

    public function delete_location($id){
        $location =  JobLocation::find($id)->delete();
        return redirect(route('job_order.location.all_locations'))->with('flash_success','Order Location deleted successfully');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
