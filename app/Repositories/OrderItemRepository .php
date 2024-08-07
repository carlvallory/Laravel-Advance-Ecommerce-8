<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function all()
    {
        return OrderItem::all();
    }

    public function find($id)
    {
        return OrderItem::find($id);
    }

    public function create(array $data)
    {
        return OrderItem::create($data);
    }

    public function update($id, array $data)
    {
        $user = OrderItem::find($id);
        return $user ? $user->update($data) : false;
    }

    public function delete($id)
    {
        $user = OrderItem::find($id);
        return $user ? $user->delete() : false;
    }

    public function save(array $data) {

    }
}
