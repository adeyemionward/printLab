<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobPaymentNewHistory extends Model
{
    use HasFactory;
    public function jobOrder1()
    {
        return $this->belongsTo(JobOrder::class, 'job_order_id');
    }

    public function jobOrder()
    {
        return $this->hasOneThrough(
            JobOrder::class,          // The final model we want to access
            JobOrderUnique::class,    // The intermediate model
            'id',                     // Foreign key on JobOrderUnique table...
            'job_order_unique_id',    // Foreign key on JobOrder table...
            'job_order_unique_id',    // Local key on JobPaymentNewHistory table...
            'id'                      // Local key on JobOrderUnique table.
        );
    }

    public static function saveJobPaymentHistory($job_order_id, $customer_id, $company_id, $amount_paid, $payment_type, $order_date, $user_id)
    {
     $user = Auth::user();
        $job_pay = new self(); // Instantiate the current class
        $job_pay->job_order_id    = $job_order_id;
        $job_pay->user_id         = $customer_id;
        $job_pay->company_id     = $company_id;
        $job_pay->amount          = $amount_paid;
        $job_pay->payment_type    = $payment_type;
        $job_pay->payment_date    = $order_date;
        $job_pay->created_by      = $user_id;
        return $job_pay->save();
    }

    public static function updateJobPaymentHistory($job_order_id, $customer_id, $company_id, $amount_paid, $payment_type, $order_date, $user_id){
        //save to payment history
        $user = Auth::user();
        $job_pay =  JobPaymentHistory::where('job_order_id',$job_order_id)->first();
        $job_pay->user_id         = $customer_id;
        $job_pay->company_id     = $company_id;
        $job_pay->amount          = $amount_paid;
        $job_pay->payment_type    = $payment_type;
        $job_pay->payment_date    = $order_date;
        $job_pay->updated_by      = $user_id;
        return $job_pay->save();
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
public function jobOrderUnique()
{
    // This defines the relationship from the payment back to the order.
    // Make sure the keys ('order_no', 'order_no') match your database columns.
    return $this->belongsTo(JobOrderUnique::class, 'order_no', 'order_no');
}
    public static function getTotalPaidForUser(int $userId): float
{
    // This query finds all payments that belong to orders placed by the specified user.
    return self::whereHas('jobOrderUnique', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->sum('amount');
}
}
