<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;
    protected $fillable = [
    'item_name',
    'unit',
    'inventory_category_id',
    'min_stock',
    'description',
    'current_stock',
    ];

    public function category(){
        return $this->belongsTo(InventoryCategory::class,'inventory_category_id', 'id');
    }
}
