<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'quantity',
        'category',
        'url_imagen',
        'description',
        'unit_price',
        'seller_phone',
        'seller_address',
        'seller_ref',
        'seller_coords'
    ];

    protected $hidden = [
        'public_key'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class)->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
}
