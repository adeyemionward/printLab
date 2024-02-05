<?php

    namespace App\Repository;
    use App\Models\JobOrderTracking;
    use App\Models\JobOrder;
    use App\Models\JobPaymentHistory;
    use Illuminate\Support\Facades\DB;
    use App\Models\HigherNoteBook;;
    use App\Models\EightyLeavesBook;
    use App\Models\FortyLeavesBook;
    use App\Models\TwentyLeavesBook;
    use Illuminate\Support\Facades\Auth;

    class NoteBookRepository
    {
        public function noteBookOrder($data){
            DB::beginTransaction();
            try{
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
                $job_order = new JobOrder();
                $job_order->user_id     = $customer_id;
                $job_order->job_order_name  = $data['note_type'];
                $job_order->quantity        = $quantity;
                $job_order->ink             = $ink;
                $job_order->paper_type      = $paper_type;
                $job_order->production_days = $production_time;
                $job_order->thickness      = $thickness;
                $job_order->proof_needed    = $proof_needed;
                $job_order->total_cost      = $total_cost;
                $job_order->order_date     = $order_date;
                $job_order->order_type      = 'internal';
                $job_order->cart_order_status      = 1;
                $job_order->job_location_id        = $location;
                $job_order->created_by      = $user->id;
                $job_order->save();

                // //save to higher education
                // $eighty_leaves = new EightyLeavesBook();
                // $eighty_leaves->job_order     = $job_order->id;
                // $eighty_leaves->save();

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
                return ['success' => false, 'error' => $th->getMessage()];
            }
            return ['success' => true, 'job_order' => $job_order];
        }

    }

?>