<?php

namespace App\Repositories;

use App\Enums\DonationRequestScheduleStatusEnum;
use App\Enums\DonationRequestStatusEnum;
use App\Models\DonationRequest;
use App\Models\DonationRequestSchedule;
use App\Models\Hospital;
use App\Models\User;
use App\Repositories\Contracts\DonationRequestRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DonationRequestRepository implements DonationRequestRepositoryInterface
{
    public function all()
    {
        return DonationRequest::all();
    }

    public function allByDonor()
    {
        $user = Auth::user();
        return User::with(['donations' => function ($query) {
            $query->with(['hospital', 'latestActiveSchedule', 'latestRescheduleRequest', 'latestDeclinedRescheduleRequest'])
                ->orderBy('id', 'asc');
        }])
            ->where('id', $user->id)
            ->first();
    }

    public function allByHospital(int $hospital_id)
    {
        return DonationRequest::with(['user' => function ($query) {
            $query->orderBy('id', 'asc');
        }])
            ->where('hospital_id', $hospital_id)
            ->where('status', DonationRequestStatusEnum::Pending)
            ->get();
    }

    public function allRescheduleByHospital(int $hospital_id)
    {
        return DonationRequest::with(['user' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'latestActiveSchedule', 'latestRescheduleRequest'])
            ->where('hospital_id', $hospital_id)
            ->where('status', DonationRequestStatusEnum::RescheduleRequest)
            ->get();
    }

    public function find(int $id)
    {
        return DonationRequest::findOrFail($id);
    }

    public function create(array $data)
    {
        $donationRequest = DonationRequest::create($data);
        return DonationRequest::with(['user', 'hospital', 'hospital.user'])->where('id', $donationRequest->id)->first();
    }

    public function update(int $id, array $data)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update($data);
        return $donationRequest;
    }

    public function approve(int $id, array $data)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Approved]);
        DonationRequestSchedule::where('donation_request_id', $donationRequest->id)
            ->update(['status' => DonationRequestScheduleStatusEnum::Inactive]);
        DonationRequestSchedule::create([
            'donation_request_id' => $donationRequest->id,
            'date' => $data['date'],
            'notes' => $data['notes'],
            'status' => DonationRequestScheduleStatusEnum::Active
        ]);
        return $donationRequest;
    }

    public function reschedule(int $id, array $data)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::RescheduleRequest]);
        // DonationRequestSchedule::where('donation_request_id', $donationRequest->id)
        //     ->update(['status' => DonationRequestScheduleStatusEnum::Inactive]);
        DonationRequestSchedule::create([
            'donation_request_id' => $donationRequest->id,
            'date' => $data['date'],
            'notes' => $data['notes'],
            'status' => DonationRequestScheduleStatusEnum::Pending
        ]);
        // return $donationRequest;
        return User::with(['donations' => function ($query) use ($donationRequest) {
            $query->with(['hospital', 'hospital.user', 'latestActiveSchedule', 'latestRescheduleRequest', 'latestDeclinedRescheduleRequest'])
                ->where('id', $donationRequest->id);
        }])->find($donationRequest->user_id);
    }

    public function approveReschedule(int $id)
    {
        $donationRequestSchedule = DonationRequestSchedule::findOrFail($id);
        DonationRequestSchedule::where('donation_request_id', $donationRequestSchedule->donation_request_id)
            ->update(['status' => DonationRequestScheduleStatusEnum::Inactive]);
        $donationRequestSchedule->update(['status' => DonationRequestScheduleStatusEnum::Active]);
        $donationRequest = DonationRequest::findOrFail($donationRequestSchedule->donation_request_id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Approved]);
        return $donationRequest;
    }

    public function declineReschedule(int $id)
    {
        $donationRequestSchedule = DonationRequestSchedule::findOrFail($id);
        $donationRequestSchedule->update(['status' => DonationRequestScheduleStatusEnum::Declined]);
        $donationRequest = DonationRequest::findOrFail($donationRequestSchedule->donation_request_id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Approved]);
        return $donationRequest;
    }

    public function cancel(int $id)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Cancelled]);
        return $donationRequest;
    }

    public function delete(int $id)
    {
        return DonationRequest::destroy($id);
    }
}
