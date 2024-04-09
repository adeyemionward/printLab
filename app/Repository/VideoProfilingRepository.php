<?php

    namespace App\Repository;
    use App\Models\JobOrderTracking;
    use App\Models\JobPaymentHistory;
    use App\Models\JobOrder;
    use Illuminate\Support\Facades\DB;
    use App\Models\VideoProfiling;
    use Illuminate\Support\Facades\Auth;

    class VideoProfilingRepository
    {
        public function postInternalVideoProfiling($data){
            DB::beginTransaction();
            //try{
                $user = Auth::user();
                $order_date = date('Y-m-d');

                $customer_id                =  $data['customer_id'];
                $quantity                   =  $data['quantity'];
                $cover_paper                =  $data['cover_paper'];
                $screen_size                =  $data['screen_size'];
                $display_area               =  $data['display_area'];
                $resolution                 =  $data['resolution'];
                $battery                    =  $data['battery'];
                $memory                     =  $data['memory'];
                $order_type                 =  'internal';
                $payment_type               =  $data['payment_type'];
                $total_cost                 =  $data['total_cost'];
                $production_time            =  $data['production_time'];
                $amount_paid                =  $data['amount_paid'];
                $location                   =  $data['location'];

                //save to job
                $job_order = new JobOrder();
                $job_order->user_id     = $customer_id;
                $job_order->job_order_name  = 'Video Bronchure';
                $job_order->quantity        = $quantity;
                $job_order->cover_paper             = $cover_paper;
                $job_order->screen_size      = $screen_size;
                $job_order->production_days = $production_time;
                $job_order->display_area      = $display_area;
                $job_order->resolution      = $resolution;
                $job_order->battery     = $battery;
                $job_order->memory      = $memory;
                $job_order->order_type      = $order_type;
                $job_order->cart_order_status      = 1;
                $job_order->total_cost      = $total_cost;
                $job_order->job_location_id        = $location;
                $job_order->created_by      = $user->id;
                $job_order->save();

                JobOrderTracking::saveJobOrderTracking($job_order->id, $order_date);
                JobPaymentHistory::saveJobPaymentHistory($job_order->id, $customer_id, $amount_paid, $payment_type, $order_date, $user->id);

                DB::commit();
            // }catch(\Exception $th){
            //     DB::rollBack();
            //     return redirect()->back()->with('flash_error','An Error Occured: Please try later');
            // }
            return redirect(route('customers.customer_cart', $customer_id))->with('flash_success','Product added to Cart');
        }


        public function updateNoteBookOrder($data){
            DB::beginTransaction();
             try{
                $id = request()->id;
                $user = Auth::user();
                $order_date = date('Y-m-d');

                $customer_id                =  $data['customer_id'];
                $quantity                   =  $data['quantity'];
                $ink                        =  $data['ink'];
                $paper_type                 =  $data['paper_type'];
                $production_time            =  $data['production_time'];
                $thickness                  =  $data['thickness'];
                $proof_needed               =  $data['proof_needed'];
                $total_cost                 =  $data['total_cost'];

                $amount_paid                =  $data['amount_paid'];
                $payment_type               =  $data['payment_type'];
                $location                   =  $data['location'];


                //save to job
                $job_order =  JobOrder::find($id);
                $job_order->user_id     = $customer_id;
                $job_order->job_order_name  = $data['note_type'];
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

                JobPaymentHistory::updateJobPaymentHistory($id, $customer_id, $amount_paid, $payment_type, $order_date, $user->id);

                DB::commit();
             }catch(\Exception $th){
                DB::rollBack();
                return redirect()->back()->with('flash_error','An Error Occured: Please try later');
             }
            // return redirect(route('job_order.view_order',['Eighty_Leaves',$id]))->with('flash_success','Eighty Leaves Book order updated successfully');
            return redirect(route('job_order.view_order',[request()->job_title,$id]))->with('flash_success', $data["note_type"].' Book order updated successfully');
            // return redirect(route('customers.customer_cart', $customer_id))->with('flash_success','Product added to Cart');
        }

    }

?>
