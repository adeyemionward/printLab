<?php

namespace App\Repository;
use App\Models\JobOrderTracking;
use App\Models\JobOrder;
use App\Models\JobPaymentHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class ServiceOrderRepository
{
    public function serviceOrder($data)
    {
        DB::beginTransaction();
        try{
            $user = Auth::user();
            $order_date = date('Y-m-d');
            $customer_id                =  $data['customer_id'];
            $quantity                   =  $data['quantity'];
            $ink                        =  $data['ink'];
            $production_time            =  $data['production_time'];
            $total_cost                 =  $data['total_cost'];
            $amount_paid                =  $data['amount_paid'];
            $payment_type               =  $data['payment_type'];
            $location                   =  $data['location'];

            $marketerId = User::find($customer_id)->marketer_id;
            //save to job
            $job_order = new JobOrder();
            $job_order->user_id         = $customer_id;
            $job_order->marketer_id     = $marketerId ?? null;
            $job_order->company_id      = $user->company_id;
            $job_order->job_order_name  = 'Service';
            $job_order->quantity        = $quantity;
            $job_order->ink             = $ink;
            $job_order->production_days = $production_time;
            $job_order->total_cost      = $total_cost;
            $job_order->order_date      = $order_date;
            $job_order->order_type      = 'internal';
            $job_order->cart_order_status      = 1;
            $job_order->job_location_id        = $location;
            $job_order->created_by      = $user->id;
            $job_order->save();

            JobOrderTracking::saveJobOrderTracking($job_order->id, $order_date);
            JobPaymentHistory::saveJobPaymentHistory($job_order->id, $customer_id, $user->company_id, $amount_paid, $payment_type, $order_date, $user->id);
            DB::commit();

        }catch(\Exception $th){
            DB::rollBack();
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }
        return redirect(route('company.customers.customer_cart', $customer_id))->with('flash_success','Product added to Cart');

    }


    public function updateserviceOrder($data)
    {
        DB::beginTransaction();
        try{
            $id = request()->id;
            $user = Auth::user();
            $order_date = date('Y-m-d');
            $customer_id                =  $data['customer_id'];
            $quantity                   =  $data['quantity'];
            $ink                        =  $data['ink'];
            $production_time            =  $data['production_time'];
            $total_cost                 =  $data['total_cost'];
            $amount_paid                =  $data['amount_paid'];
            $payment_type               =  $data['payment_type'];
            $location                   =  $data['location'];

            $marketerId = User::find($customer_id)->marketer_id;
            //save to job
            $job_order =  JobOrder::find($id);
            $job_order->user_id         = $customer_id;
            $job_order->marketer_id     = $marketerId ?? null;
            $job_order->job_order_name  = 'Service';
            $job_order->quantity        = $quantity;
            $job_order->ink             = $ink;
            $job_order->production_days = $production_time;
            $job_order->total_cost      = $total_cost;
            $job_order->job_location_id = $location;
            $job_order->created_by      = $user->id;
            $job_order->save();

            JobPaymentHistory::updateJobPaymentHistory($id, $customer_id, $user->company_id, $amount_paid, $payment_type, $order_date, $user->id);
            DB::commit();

        }catch(\Exception $th){
            DB::rollBack();
            return redirect()->back()->with('flash_error','An Error Occured: Please try later');
        }
        return redirect(route('company.job_order.view_order',[request()->job_title,$id]))->with('flash_success', 'Service order updated successfully');

    }
}


?>
