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
}
