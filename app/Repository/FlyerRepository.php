<?php

    namespace App\Repository;
    use App\Models\JobOrderTracking;
    use App\Models\JobOrder;
    use App\Models\JobPaymentHistory;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

    class FlyerRepository
    {
        public function postFlyer($data){
            DB::beginTransaction();
            try{
                $user = Auth::user();
                $order_date = date('Y-m-d');

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

                $amount_paid                =  request('amount_paid');
                $payment_type               =  request('payment_type');
                $location                   =  request('location');

                //save to job
                $job_order = new JobOrder();
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
                $job_order->order_date     = $order_date;
                $job_order->order_type     = 'internal';
                $job_order->cart_order_status      = 1;
                $job_order->job_location_id        = $location;
                $job_order->created_by      = $user->id;
                $job_order->save();

                JobOrderTracking::saveJobOrderTracking($job_order->id, $order_date);
                JobPaymentHistory::saveJobPaymentHistory($job_order->id, $customer_id, $amount_paid, $payment_type, $order_date, $user->id);
                DB::commit();
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            }
            return redirect(route('customers.customer_cart', $customer_id))->with('flash_success','Product added to Cart');
        }

    }

?>
