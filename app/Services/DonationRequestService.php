<?php

namespace App\Services;

use App\Enums\DonationRequestStatusEnum;
use App\Models\Hospital;
use App\Repositories\Contracts\DonationRequestRepositoryInterface;
use App\Repositories\Contracts\HospitalRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

class DonationRequestService
{
    protected $repository;
    protected $userRepository;
    protected $hospitalRepository;

    public function __construct(
        DonationRequestRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        HospitalRepositoryInterface $hospitalRepository,
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->hospitalRepository = $hospitalRepository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getAllByDonor()
    {
        return $this->repository->allByDonor();
    }

    public function getAllByHospital()
    {
        $user = Auth::user();
        if (!$user || $user->role->value !== 'hospital') {
            abort(403, 'Forbidden.');
        }
        $hospital = Hospital::where('user_id', $user->id)->first();
        if (!$hospital) {
            abort(403, 'Forbidden.');
        }
        return $this->repository->allByHospital($hospital->id);
    }

    public function getById(int $id)
    {
        return $this->repository->find($id);
    }

    public function create()
    {
        $data = [];
        $user = Auth::user();
        $location = explode('|', $user->location);
        $nearestHospital = $this->hospitalRepository->findNearestHospital($location[1], $location[2]);
        $data['user_id'] = $user->id;
        $data['hospital_id'] = $nearestHospital->id;
        $data['date'] = now();
        $data['status'] = DonationRequestStatusEnum::Pending;
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function approve(int $id, array $data)
    {
        return $this->repository->approve($id, $data);
    }

    public function cancel(int $id)
    {
        return $this->repository->cancel($id);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
