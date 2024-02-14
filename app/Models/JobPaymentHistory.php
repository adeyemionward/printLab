<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPaymentHistory extends Model
{
    use HasFactory;

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class, 'job_order_id');
    }

    public static function saveJobPaymentHistory($job_order_id, $customer_id, $amount_paid, $payment_type, $order_date, $user_id)
    {
        $job_pay = new self(); // Instantiate the current class
        $job_pay->job_order_id    = $job_order_id;
        $job_pay->user_id         = $customer_id;
        $job_pay->amount          = $amount_paid;
        $job_pay->payment_type    = $payment_type;
        $job_pay->payment_date    = $order_date;
        $job_pay->created_by      = $user_id;
        return $job_pay->save();
    }

    public static function updateJobPaymentHistory($job_order_id, $customer_id, $amount_paid, $payment_type, $order_date, $user_id){
        //save to payment history
        $job_pay =  JobPaymentHistory::where('job_order_id',$job_order_id)->first();
        $job_pay->user_id         = $customer_id;
        $job_pay->amount          = $amount_paid;
        $job_pay->payment_type    = $payment_type;
        $job_pay->payment_date    = $order_date;
        $job_pay->updated_by      = $user_id;
        return $job_pay->save();
    }
}
