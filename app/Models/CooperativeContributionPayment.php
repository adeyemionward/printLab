<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CooperativeContributionPayment extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'amount'];

    // Define the relationship to Member
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    // Define the method to get total amount paid by each member
    public function totalAmountPaidByMember()
    {
        return $this->hasOne(User::class, 'id', 'member_id')
            ->selectRaw('member_id, SUM(amount) as total_amount')
            ->groupBy('member_id');
    }


    public function staff(){
        return $this->belongsTo(User::class,'collector_id','id');
    }

    public function created_by(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
