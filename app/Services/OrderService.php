<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function getOrderById($id)
    {
        return Order::find($id);
    }

    public function createOrder(array $data)
    {
        return Order::create($data);
    }

    public function updateOrder($id, array $data)
    {
        $order = Order::find($id);
        if ($order) {
            $order->update($data);
            return $order;
        }
        return null;
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return true;
        }
        return false;
    }

    // Agrega otros métodos relacionados con la lógica de negocio de las órdenes según sea necesario
}
