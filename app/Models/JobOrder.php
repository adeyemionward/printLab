<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    const job_cart_status = 1;
    const ORDER_COMPLETED = 2;

    protected $fillable = [
        'ink',
        'paper_type',
        'quantity',
        'thickness',
        'total_cost',
        'memory',
        'cover_paper'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }


    public function productName(){
        return $this->hasOne(Product::class,'id','product_id');
    }



    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function location(){
        return $this->belongsTo(JobLocation::class,'job_location_id','id');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }

    // public function jobPaymentHistories(){
    //     return $this->hasMany(JobPaymentHistory::class,'id','job_order_id');
    // }
    public function jobPaymentHistories()
    {
        return $this->hasMany(JobPaymentHistory::class, 'job_order_id', 'id');
    }
    public function jobPaymentHistory(){
        return $this->belongsTo(JobPaymentHistory::class,'id','job_order_id');
    }

    public static function jobOrderCount($user_id){
        return $jobOrderCount = JobOrder::where('user_id',$user_id)->count();
    }

}
