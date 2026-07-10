<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPricingVolume extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'product_type_id',
        'min_qty',
        'max_qty',
        'cost',
    ];

    public function productType()
    {
        // 'product_type_id' is the foreign key on your product_pricing_volumes table
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
