<?php

    namespace App\Services;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;
    class CustomerService
    {
        // public function __construct(){
        //     $user = Auth::user();
        // }

        public function postCustomer($data){

            DB::beginTransaction();
            try{
                $user_logged = Auth::user();
                $user = new User();
                $user->firstname    = request('firstname');
                $user->lastname     = request('lastname');
                $user->email        = request('email');
                $user->phone        = request('phone');
                $user->gender       = request('gender');
                $user->address      = request('address');
                $user->membership_type      = request('membership_type');
                $user->membership_no      = request('membership_no');
                $user->status       = 'active';
                $user->user_type    = USER::MEMBER;
                $user->password     = bcrypt(request('firstname'));
                $user->nonsh     = request('firstname');
                $user->created_by    = $user_logged->id;
                $user->save();


                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('dashboard.admin.parties.customer.index'))->with('flash_success','Customer saved successfully');
        }

        public function updateBooklet($data){
            DB::beginTransaction();
            try{
                $id = request()->id;
                $user = Auth::user();
                $order_date = date('Y-m-d');

                $customer_id                =  request('customer_id');
                $quantity                   =  request('quantity');
                $size                       =  request('size');
                $ink                        =  request('ink');
                $paper_type                 =  request('paper_type');
                $page_count                 =  request('page_count');
                $production_time            =  request('production_time');
                $back_sided_print           =  request('back_sided_print');
                $proof_needed               =  request('proof_needed');
                $hole_drilling              =  request('hole_drilling');
                $cut_to_size                =  request('cut_to_size');
                $books_with_cover           =  request('books_with_cover');
                $shrink_wrap                =  request('shrink_wrap');
                $numbering_needed           =  request('numbering_needed');
                $start_number               =  request('start_number');
                $total_cost                 =  request('total_cost');

                $amount_paid                =  request('amount_paid');
                $payment_type               =  request('payment_type');
                $location                   =  request('location');

                //save to job
                $job_order =  JobOrder::find($id);
                $job_order->user_id     = $customer_id;
                $job_order->job_order_name  = 'Booklet';
                $job_order->quantity        = $quantity;
                $job_order->size            = $size;
                $job_order->ink             = $ink;
                $job_order->paper_type      = $paper_type;
                $job_order->page_count      = $page_count;
                $job_order->production_days = $production_time;
                $job_order->back_sided_print    = $back_sided_print;
                $job_order->proof_needed    = $proof_needed;
                $job_order->hole_drilling   = $hole_drilling;
                $job_order->cut_to_size     = $cut_to_size;
                $job_order->books_with_covers     = $books_with_cover;
                $job_order->shrink_wrap     = $shrink_wrap;
                $job_order->numbering_needed     = $numbering_needed;
                $job_order->start_number     = $start_number;
                $job_order->total_cost      = $total_cost;
                $job_order->job_location_id        = $location;
                $job_order->updated_by      = $user->id;
                $job_order->save();

                JobPaymentHistory::saveJobPaymentHistory($id, $customer_id, $amount_paid, $payment_type, $order_date, $user->id);


                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('job_order.view_order',[request()->job_title,$id]))->with('flash_success', 'Booklet order updated successfully');
        }

    }

?>
