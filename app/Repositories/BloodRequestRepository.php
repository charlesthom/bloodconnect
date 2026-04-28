<?php

namespace App\Repositories;

use App\Enums\BloodRequestStatusEnum;
use App\Mail\BloodRequestMail;
use App\Mail\BloodRequestOwnerMail;
use App\Models\BloodRequest;
use App\Mail\BloodRequestFulfilledMail;
use App\Mail\BloodRequestFulfilledOwnerMail;
use App\Models\DonationRequest;
use App\Models\Hospital;
use App\Repositories\Contracts\BloodRequestRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\BloodAvailability;

class BloodRequestRepository implements BloodRequestRepositoryInterface
{
    public function all()
    {
        return BloodRequest::whereHas('hospital', function ($q) {
            $q->whereNull('deleted_at');
        })
            ->with(['hospital' => function ($query) {
                $query->with('user');
            }])
            ->with(['confirmedBy'])
            ->get();
    }

    public function allByHospital()
    {
        $user = Auth::user();
        $hospital = Hospital::where('user_id', $user->id)->first();
        return BloodRequest::with(['hospital' => function ($query) {
            $query->with(['user']);
        }])
            ->where('hospital_id', $hospital->id)
            ->get();
    }

    public function find(int $id)
    {
        return BloodRequest::findOrFail($id);
    }

   public function create(array $data)
{
    $user = Auth::user();
    $hospital = Hospital::where('user_id', $user->id)->first();

    $data['hospital_id'] = $hospital->id;
    $data['status'] = BloodRequestStatusEnum::Pending;
    $data['request_date'] = Carbon::now();

    $create = BloodRequest::create($data);
    

    $bloodRequest = BloodRequest::with(['hospital', 'hospital.user'])
        ->where('id', $create->id)
        ->first();
        $hasMatch = BloodAvailability::where('blood_type', $bloodRequest->blood_type)
    ->where('quantity', '>=', (int) $bloodRequest->quantity)
    ->where('status', 'available')
    ->where('hospital_id', '<>', $hospital->id)
    ->exists();

if ($hasMatch) {
    $create->update([
        'status' => BloodRequestStatusEnum::Matched,
    ]);
}

    $matchedAvailabilities = BloodAvailability::with(['hospital.user'])
        ->where('blood_type', $bloodRequest->blood_type)
        ->where('quantity', '>=', (int) $bloodRequest->quantity)
        ->where('status', 'available')
        ->where('hospital_id', '<>', $hospital->id)
        ->get();

    $hospitals = $matchedAvailabilities
        ->pluck('hospital')
        ->filter()
        ->unique('id')
        ->values();
        

    Mail::to($bloodRequest->hospital->user->email)
        ->queue(new BloodRequestOwnerMail($bloodRequest));

    foreach ($hospitals as $hos) {
        Mail::to($hos->user->email)
            ->queue(new BloodRequestMail($bloodRequest, $hos));
    }

    return $bloodRequest;
}

    public function fulfill(int $id)
{
    $user = Auth::user();
    $hospital = Hospital::where('user_id', $user->id)->first();

    $bloodRequest = BloodRequest::findOrFail($id);

// 🚫 Prevent self-fulfill
if ($bloodRequest->hospital_id == $hospital->id) {
    abort(403, 'You cannot fulfill your own request.');
}

// 🚫 Prevent already fulfilled
if ($bloodRequest->status === BloodRequestStatusEnum::Fulfilled) {
    abort(403, 'Request already fulfilled.');
}

// 🔍 Check availability
$totalAvailable = BloodAvailability::where('hospital_id', $hospital->id)
    ->where('blood_type', $bloodRequest->blood_type)
    ->where('status', 'available')
    ->sum('quantity');

// 🚫 Not enough stock
if ($totalAvailable < (int) $bloodRequest->quantity) {
    abort(403, 'Insufficient blood availability.');
}

    

    $remaining = (int) $bloodRequest->quantity;

$availabilities = BloodAvailability::where('hospital_id', $hospital->id)
    ->where('blood_type', $bloodRequest->blood_type)
    ->where('status', 'available')
    ->orderBy('created_at') // FIFO (optional but good)
    ->get();

foreach ($availabilities as $availability) {

    if ($remaining <= 0) break;

    if ((int) $availability->quantity >= $remaining) {
        $availability->quantity -= $remaining;
        $remaining = 0;
    } else {
        $remaining -= (int) $availability->quantity;
        $availability->quantity = 0;
    }

    if ($availability->quantity <= 0) {
        $availability->quantity = 0;
        $availability->status = 'reserved';
    }

    $availability->save();
}
$bloodRequest->update([
        'status' => BloodRequestStatusEnum::Fulfilled,
        'confirmed_by' => $hospital->id,
    ]);

    $bloodRequest->load(['hospital', 'hospital.user', 'confirmedBy']);

    if (!empty($bloodRequest->hospital->user->email)) {
        Mail::to($bloodRequest->hospital->user->email)
            ->queue(new \App\Mail\BloodRequestFulfilledOwnerMail($bloodRequest));
    }

    if (!empty($hospital->user->email)) {
        Mail::to($hospital->user->email)
            ->queue(new \App\Mail\BloodRequestFulfilledMail($bloodRequest));
    }

    return $bloodRequest;
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
