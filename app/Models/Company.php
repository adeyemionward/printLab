<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    
    CONST ACTIVE    = 'active';
    CONST INACTIVE  = 'inactive';

    protected $fillable = [
        'id',
        'sub_amount',
        'sub_start_date',
        'sub_end_date',
        'plan',
        'status',
    ];
}
