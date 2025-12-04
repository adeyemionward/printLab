<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'item_id',         // reference to inventory item
        'user_id',         // user who performed the action
        'previous_stock',  // stock before change
        'qty_change',      // quantity added or removed
        'current_stock',   // stock after change
        'type',            // 'IN' or 'OUT'
        'note',            // optional note or reason
        'supplier_id',     // reference to supplier (for stock IN)
        'receiver_id',     // reference to receiver (for stock OUT)

    ];

    /**
     * Optional relationships
     */
    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'suppliedr_id');
    }
}
