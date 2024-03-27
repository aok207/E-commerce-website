<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'payment_type', 'payment_status', 'email', 'shipping_address', 'zip_code', 'city', 'tax_fees', 'shipping_fees', 'total_items_price', 'final_amount'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
