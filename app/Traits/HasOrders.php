<?php

namespace App\Traits;

use App\Models\Order;

trait HasOrders {

    public function Orders(){
        $this->morphMany(Order::class, 'user');
    }
}
