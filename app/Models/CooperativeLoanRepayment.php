<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperativeLoanRepayment extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'amount'];

    // Define the relationship to Member
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    } 

    public function loan_details()
    {
        return $this->belongsTo(CooperativeLoanPayout::class, 'loan_payout_id');
    }
}
