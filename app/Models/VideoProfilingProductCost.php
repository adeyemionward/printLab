<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoProfilingProductCost extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_name',
        'quantity',
        'total_cost'
    ];
}
