<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrderTracking extends Model
{
    use HasFactory;

    public static function saveJobOrderTracking($job_order_id, $order_date)
    {
        $job_tracking = new self(); // Instantiate the current class
        $job_tracking->job_order_id = $job_order_id;
        $job_tracking->pending_status = 1;
        $job_tracking->pending_date = $order_date;
        return $job_tracking->save();
    }
}
