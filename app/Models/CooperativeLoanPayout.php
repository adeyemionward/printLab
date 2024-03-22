<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperativeLoanPayout extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'amount','amount_payout','amount_repayed'];

    // Define the relationship to Member
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
