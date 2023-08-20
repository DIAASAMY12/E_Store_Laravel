<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{
    protected $model;

    public function __construct(Address $address)
    {
        $this->model = $address;
    }

    public function findByUserId($userId)
    {
        return $this->model->where('addressable_id', $userId)->first();
    }
}
