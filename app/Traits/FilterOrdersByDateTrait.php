<?php
namespace App\Traits;

use App\Models\JobOrder;
use Illuminate\Http\Request;

trait FilterOrdersByDateTrait
{
    public function filterOrdersByDate(Request $request = null){
        $startDate  = request('date_from');
        $endDate    = request('date_to');
        $location   = request('location');

        //Start building the query
        $query = JobOrder::query();

        // Apply date range filter if both dates are provided
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        // Apply location filter if provided
        if (!empty($location)) {
            $query->where('job_location_id', $location);
        }

        // Execute the query and get the results
        $data = $query;
        return $data;
    }
}
