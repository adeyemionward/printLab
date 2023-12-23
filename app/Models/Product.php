<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function productCost(){
        return $this->hasOne(ProductCost::class,'product_id','id');
    }

    
}


