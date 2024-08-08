<?php

namespace App\Traits;

use App\Models\OrderItem;

trait HasOrderItem {

    public function OrderItem(){
        $this->morphMany(OrderItem::class, 'product');
    }
}
