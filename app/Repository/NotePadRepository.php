<?php

    namespace App\Repository;
    use App\Models\JobOrderTracking;
    use App\Models\JobOrder;
    use App\Models\JobPaymentHistory;
    use Illuminate\Support\Facades\DB;
    use App\Models\NotePad;

    use Illuminate\Support\Facades\Auth;

    class NotePadRepository
    {
        public function postNotePadOrder($data){
            DB::beginTransaction();
            try{
                $user = Auth::user();
                $order_date = date('Y-m-d');

                $customer_id                =  request('customer_id');
                $quantity                   =  request('quantity');
                $size                       =  request('size');
                $ink                        =  request('ink');
                $paper_type                 =  request('paper_type');
                $page_count                 =  request('page_count');
                $perforating                =  request('perforating');
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
                $job_order = new JobOrder();
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
                $job_order->order_date     = $order_date;
                $job_order->order_type     = 'internal';
                $job_order->cart_order_status      = 1;
                $job_order->created_by      = $user->id;
                $job_order->job_location_id        = $location;
                $job_order->save();

                JobOrderTracking::saveJobOrderTracking($job_order->id, $order_date);
                JobPaymentHistory::saveJobPaymentHistory($job_order->id, $customer_id, $user->company_id, $amount_paid, $payment_type, $order_date, $user->id);

                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('customers.customer_cart', $customer_id))->with('flash_success','Product added to Cart');
        }

        public function updateNotePadOrder($data){
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
                $perforating                =  request('perforating');
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
                $job_order->user_id             = $customer_id;
                $job_order->job_order_name      = 'Notepads';
                $job_order->quantity            = $quantity;
                $job_order->size                = $size;
                $job_order->ink                 = $ink;
                $job_order->paper_type          = $paper_type;
                $job_order->page_count          = $page_count;
                $job_order->production_days     = $production_time;
                $job_order->perforating         = $perforating;
                $job_order->back_sided_print    = $back_sided_print;
                $job_order->proof_needed        = $proof_needed;
                $job_order->hole_drilling       = $hole_drilling;
                $job_order->cut_to_size         = $cut_to_size;
                $job_order->books_with_covers   = $books_with_cover;
                $job_order->shrink_wrap         = $shrink_wrap;
                $job_order->numbering_needed    = $numbering_needed;
                $job_order->start_number        = $start_number;
                $job_order->total_cost          = $total_cost;
                $job_order->updated_by          = $user->id;
                $job_order->job_location_id     = $location;
                $job_order->save();

                JobPaymentHistory::updateJobPaymentHistory($id, $customer_id, $user->company_id, $amount_paid, $payment_type, $order_date, $user->id);

                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('job_order.view_order',[request()->job_title,$id]))->with('flash_success', 'Notepad order updated successfully');
        }
    }

?>
