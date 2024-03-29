<?php
namespace App\Traits;

use App\Models\JobOrder;
use Illuminate\Http\Request;

trait FilterOrdersByDateTrait
{
    public function filterOrdersByDate(Request $request = null){
        $startDate  = request('date_from');
        $endDate    = request('date_to');

        $data = JobOrder::whereBetween('order_date', [$startDate, $endDate])->where('cart_order_status',JobOrder::job_ordered_status);

        return $data;
    }
}
