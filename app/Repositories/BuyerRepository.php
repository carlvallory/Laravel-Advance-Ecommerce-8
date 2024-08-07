<?php

namespace App\Repositories;

use App\Models\Buyer;

class BuyerRepository implements BuyerRepositoryInterface
{
    public function all()
    {
        return Buyer::all();
    }

    public function find($id)
    {
        return Buyer::find($id);
    }

    public function create(array $data)
    {
        return Buyer::create($data);
    }

    public function update($id, array $data)
    {
        $user = Buyer::find($id);
        return $user ? $user->update($data) : false;
    }

    public function delete($id)
    {
        $user = Buyer::find($id);
        return $user ? $user->delete() : false;
    }

    public function save(array $data) {

    }
}
