<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderApprovedDesign extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'id',
        'job_order_id',
        'design_name',
        'created_by',
        // 'updated_by'
    ];
}
