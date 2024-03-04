<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'ink',
        'company_id',
        'paper_type',
        'production_days',
        'thickness',
        'description',
        'image',
        'created_by'
    ];
    public function productCost(){
        return $this->hasOne(ProductCost::class,'product_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function location(){
        return $this->belongsTo(JobLocation::class,'job_location_id','id');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }


}


