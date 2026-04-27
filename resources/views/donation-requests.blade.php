@extends('layouts.user_type.auth')

@section('content')

<div class="donation-request-page-bg">
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                <span class="text-white">
                    {{ session('success') }}
                </span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>
    @endif
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                <span class="text-white">
                    {{ $error }}
                </span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>
        @endforeach
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
            
                <span class="text-white">
                    {{ session('error') }}
                </span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>
    @endif
@if(session()->has('error'))
@endif


    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <x-confirm-create-donation-request :nearbyHospitals="$nearbyHospitals" />
                <x-reschedule-request />

@php
    $latestPendingRequest = collect($data->donations)
        ->where('status', 'Pending')
        ->sortByDesc('created_at')
        ->first();

    $latestPendingRescheduleRequest = collect($data->donations)
        ->filter(function ($donation) {
            return $donation->latestRescheduleRequest
                && $donation->latestRescheduleRequest->status === 'Pending';
        })
        ->sortByDesc('created_at')
        ->first();

    $latestApprovedRequest = collect($data->donations)
        ->filter(function ($donation) {
            return $donation->status === 'Approved' && $donation->latestActiveSchedule;
        })
        ->sortByDesc(function ($donation) {
            return $donation->latestActiveSchedule?->date;
        })
        ->first();

    $eligibleDate = null;
    $blockMessage = null;

    if ($latestPendingRequest) {
        $blockMessage = 'You already have a pending donation request.';
    } elseif ($latestPendingRescheduleRequest) {
        $blockMessage = 'You already have a pending reschedule request.';
    } elseif ($latestApprovedRequest && $latestApprovedRequest->latestActiveSchedule?->date) {
        $scheduleDate = \Carbon\Carbon::parse($latestApprovedRequest->latestActiveSchedule->date);

        $eligibleDate = strtoupper($data->gender) === 'MALE'
            ? $scheduleDate->copy()->addMonths(4)
            : $scheduleDate->copy()->addMonths(3);

        if ($eligibleDate->isFuture()) {
            $blockMessage = 'You can donate again on ' . $eligibleDate->format('F d, Y') . '.';
        }
    }

    $hasBlockingRequest = $latestPendingRequest
        || $latestPendingRescheduleRequest
        || ($eligibleDate && $eligibleDate->isFuture());
@endphp

                <div class="card-header pb-0">
    <div class="d-flex flex-row justify-content-between align-items-start">
        <div>
            <h5 class="mb-0">Donation Requests</h5>
        </div>

        @php
            $notifications = collect($data->donations)
                ->filter(function ($donation) {
                    return in_array($donation->status, ['Approved', 'Cancelled'])
                        || ($donation->latestRescheduleRequest && in_array($donation->latestRescheduleRequest->status, ['Approved', 'Declined']));
                })
                ->sortByDesc('updated_at')
                ->values();
        @endphp

        <div class="d-flex align-items-start gap-2">
            <div class="dropdown">
                <button class="btn btn-light btn-sm position-relative shadow-sm" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-bell"></i>

                    @if($notifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notifications->count() }}
                        </span>
                    @endif
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 350px;">
                    <li class="dropdown-header fw-bold text-dark">Notifications</li>

                    @forelse($notifications as $notification)
    <li>
        <div class="dropdown-item-text border-bottom py-2">

            @if($notification->latestDeclinedRescheduleRequest && $notification->latestDeclinedRescheduleRequest->status == 'Declined')
                <strong class="text-danger">Reschedule Declined</strong><br>
                <small>Your reschedule request was declined.</small>

                @if($notification->latestDeclinedRescheduleRequest?->notes)
                    <br>
                    <small class="text-dark">
                        <strong>Reason:</strong> {{ $notification->latestDeclinedRescheduleRequest->notes }}
                    </small>
                @endif

            @elseif($notification->latestRescheduleRequest && $notification->latestRescheduleRequest->status == 'Approved')
                <strong class="text-info">Reschedule Approved</strong><br>
                <small>Your reschedule request was approved.</small>

                @if($notification->latestRescheduleRequest?->notes)
                    <br>
                    <small class="text-dark">
                        <strong>Note:</strong> {{ $notification->latestRescheduleRequest->notes }}
                    </small>
                @endif

            @elseif($notification->status == 'Cancelled')
                <strong class="text-danger">Cancelled</strong><br>
                <small>Reason: {{ $notification->notes ?? 'No reason provided' }}</small>

            @elseif($notification->status == 'Approved')
                <strong class="text-success">Approved</strong><br>
                <small>Your request to {{ $notification->hospital->name }} was approved.</small>

                @if($notification->latestActiveSchedule?->notes)
                    <br>
                    <small class="text-dark">
                        <strong>Note:</strong> {{ $notification->latestActiveSchedule->notes }}
                    </small>
                @endif
            @endif

            <br>
            <small class="text-muted">{{ $notification->updated_at->diffForHumans() }}</small>
        </div>
    </li>
@empty
    <li>
        <div class="dropdown-item-text text-muted">No notifications yet.</div>
    </li>
@endforelse
                </ul>
            </div>

                       {{-- @if(!$hasBlockingRequest)
                            <a href="#" class="btn btn-danger btn-sm mb-0"
                               data-bs-toggle="modal"
                               data-bs-target="#confirmCreateDonationRequestModal">
                               +&nbsp; New
                            </a>
                        @else
                            <div class="text-end">
                                <button class="btn btn-secondary btn-sm mb-0" disabled>
                                    +&nbsp; New
                                </button>

                                @if(isset($blockMessage))
                                    <div>
                                        <small class="text-danger fw-bold">
                                            {{ $blockMessage }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        @endif --}}
                        <a href="#" class="btn btn-danger btn-sm mb-0"
   data-bs-toggle="modal"
   data-bs-target="#confirmCreateDonationRequestModal">
    + New (TEST)
</a>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0" style="overflow-x: auto;">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hospital</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hospital Location</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Creation Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Scheduled Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested Date Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->donations as $dat)
                                @php
                                    $requestedSchedule = $dat->latestRescheduleRequest ?? $dat->latestDeclinedRescheduleRequest;
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $dat->id }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $data->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ explode('|', $data->location)[0] }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $dat->hospital->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ explode('|', $dat->hospital->location)[0] }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $dat->created_at->format('Y-m-d') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $dat->latestActiveSchedule?->date }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $dat->latestActiveSchedule?->status ?? $dat->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $requestedSchedule?->date }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $requestedSchedule?->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a 
                                            href="#"
                                            class="mx-3 {{ !$dat->latestActiveSchedule?->date ? 'disabled': '' }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rescheduleRequestModal"
                                            data-id="{{ $dat->id }}"
                                        >
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

a.disabled {
    pointer-events: none;
    opacity: 0.5;
    cursor: not-allowed;
    text-decoration: none;
}

.donation-request-page-bg {
    min-height: 100vh;
    padding-top: 10px;
    border-radius: 15px;
    background-image:
        linear-gradient(rgba(255,255,255,0.88), rgba(255,255,255,0.88)),
        url('/assets/img/hospital-bg.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.table th,
.table td {
    white-space: nowrap;
    vertical-align: middle;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const rescheduleRequestModal = document.getElementById('rescheduleRequestModal');
    const rescheduleRequestForm = document.getElementById('rescheduleRequestForm');

    rescheduleRequestModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');

        rescheduleRequestForm.action = `/donation-requests/reschedule/${id}`;
    });
});
</script>
@endpush