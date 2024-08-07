<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function all()
    {
        return Order::all();
    }

    public function find($id)
    {
        return Order::find($id);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update($id, array $data)
    {
        $user = Order::find($id);
        return $user ? $user->update($data) : false;
    }

    public function delete($id)
    {
        $user = Order::find($id);
        return $user ? $user->delete() : false;
    }

    public function save(array $data) {

    }
}
