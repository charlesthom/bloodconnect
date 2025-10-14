<?php

namespace App\Repositories;

use App\Models\BloodRequest;
use App\Models\DonationRequest;
use App\Repositories\Contracts\BloodRequestRepositoryInterface;

class BloodRequestRepository implements BloodRequestRepositoryInterface
{
    public function all()
    {
        return BloodRequest::with(['hospital' => function ($query) {
            $query->with(['user']);
        }])
            ->get();
    }

    public function find(int $id)
    {
        return BloodRequest::findOrFail($id);
    }

    public function create(array $data)
    {
        return BloodRequest::create($data);
    }

    public function update(int $id, array $data)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->update($data);
        return $bloodRequest;
    }

    public function delete(int $id)
    {
        return BloodRequest::destroy($id);
    }
}
