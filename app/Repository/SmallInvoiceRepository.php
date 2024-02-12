<?php

    namespace App\Repository;
    use App\Models\JobOrderTracking;
    use App\Models\JobOrder;
    use App\Models\JobPaymentHistory;
    use Illuminate\Support\Facades\DB;
    use App\Models\SmallInvoice;;

    use Illuminate\Support\Facades\Auth;

    class SmallInvoiceRepository
    {
        public function postSmallInvoiceOrder($data){
            DB::beginTransaction();
            try{
                $user = Auth::user();
                $order_date = date('Y-m-d');
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

                $amount_paid                =  request('amount_paid');
                $payment_type               =  request('payment_type');
                $location                   =  request('location');

                //save to job
                $job_order = new JobOrder();
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
                $job_order->order_date     = $order_date;
                $job_order->order_type     = 'internal';
                $job_order->cart_order_status      = 1;
                $job_order->created_by      = $user->id;
                $job_order->job_location_id        = $location;
                $job_order->save();

                //save to job tracking
                $job_tracking = new JobOrderTracking();
                $job_tracking->job_order_id     = $job_order->id;
                $job_tracking->pending_status   = 1;
                $job_tracking->pending_date     = $order_date;
                $job_tracking->save();

                //save to payment history
                $job_pay = new JobPaymentHistory();
                $job_pay->job_order_id    = $job_order->id;
                $job_pay->user_id         = $customer_id;
                $job_pay->amount          = $amount_paid;
                $job_pay->payment_type    = $payment_type;
                $job_pay->payment_date    = $order_date;
                $job_pay->created_by      = $user->id;
                $job_pay->save();

                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('customers.customer_cart', $customer_id))->with('flash_success','Product added to Cart');
        }
    }

?>
