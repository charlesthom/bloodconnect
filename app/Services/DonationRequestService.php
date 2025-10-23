<?php

namespace App\Services;

use App\Enums\DonationRequestStatusEnum;
use App\Mail\DonationRequestAdminMail;
use App\Mail\DonationRequestMail;
use App\Mail\RescheduleRequestAdminMail;
use App\Mail\RescheduleRequestMail;
use App\Models\Hospital;
use App\Repositories\Contracts\DonationRequestRepositoryInterface;
use App\Repositories\Contracts\HospitalRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function getAllRescheduleByHospital()
    {
        $user = Auth::user();
        if (!$user || $user->role->value !== 'hospital') {
            abort(403, 'Forbidden.');
        }
        $hospital = Hospital::where('user_id', $user->id)->first();
        if (!$hospital) {
            abort(403, 'Forbidden.');
        }
        return $this->repository->allRescheduleByHospital($hospital->id);
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
        $donationRequest = $this->repository->create($data);
        Mail::to($donationRequest->user->email)->send(new DonationRequestMail($donationRequest));
        Mail::to($donationRequest->user->email)->send(new DonationRequestAdminMail($donationRequest));
        return $donationRequest;
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function approve(int $id, array $data)
    {
        return $this->repository->approve($id, $data);
    }

    public function reschedule(int $id, array $data)
    {
        $donationRequest = $this->repository->reschedule($id, $data);
        Mail::to($donationRequest->email)->send(new RescheduleRequestMail($donationRequest));
        Mail::to($donationRequest->donations[0]->hospital->user->email)->send(new RescheduleRequestAdminMail($donationRequest));
        return $donationRequest;
    }

    public function approveReschedule(int $id)
    {
        return $this->repository->approveReschedule($id);
    }

    public function declineReschedule(int $id)
    {
        return $this->repository->declineReschedule($id);
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
