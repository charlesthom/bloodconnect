@extends('layouts.user_type.auth')

@section('content')

<div class="blood-request-bg">
    <div>
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
        {{-- @if($errors->any())
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>Validation Error:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif --}}

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
        <h6>Add Blood Availability</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('blood.availability.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <select name="blood_type" class="form-control" required>
                        <option value="">Select Blood Type</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" required>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn bg-gradient-danger w-100">
                        Add Availability
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@if(isset($myAvailabilities) && $myAvailabilities->count())
<div class="card mb-4 mx-4">
    <div class="card-header pb-0">
        <h6>Inventory</h6>
    </div>

    <div class="card-body">
        <div class="row">

            @foreach($myAvailabilities->where('quantity', '>', 0) as $availability)
                @php
                    $matchedCount = collect($matchedNotifications ?? [])
                        ->where('blood_type', $availability->blood_type)
                        ->count();
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0 availability-card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="fw-bold text-danger mb-0">
                                    {{ $availability->blood_type }}
                                </h4>

                                <span class="badge bg-success">
                                    {{ ucfirst($availability->status) }}
                                </span>
                            </div>

                            <h5 class="fw-bold mb-2">
                                {{ $availability->quantity }} Units
                            </h5>

                            <p class="mb-2 text-sm">
                                 Matched Requests:
                                <strong>{{ $matchedCount }}</strong>
                            </p>

                            <p class="text-muted small mb-3">
                                Date Added: {{ $availability->created_at->format('M d, Y') }}
                            </p>

                            <div class="d-flex gap-2">
                                <button 
                                    class="btn btn-sm bg-gradient-info editAvailabilityBtn"
                                    data-id="{{ $availability->id }}"
                                    data-blood="{{ $availability->blood_type }}"
                                    data-quantity="{{ $availability->quantity }}"
                                    data-status="{{ $availability->status }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAvailabilityModal"
                                >
                                    Edit
                                </button>

                                <form action="{{ route('blood.availability.destroy', $availability->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm bg-gradient-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endif
                    {{-- new blood request modal --}}
                    <x-create-blood-request />
                    {{-- fulfill blood request modal --}}
                    <x-fulfill-blood-request />
                    <div class="card-header pb-0">
    <div class="d-flex flex-row justify-content-between align-items-center flex-wrap gap-2">

        <!-- LEFT: TITLE -->
        <div>
            <h5 class="mb-0">Blood Requests</h5>
        </div>

       @php
    $notifications = collect($matchedNotifications ?? []);
@endphp

        <!-- RIGHT: BELL + SORT + NEW -->
        <div class="d-flex gap-2 align-items-center ms-auto">

            <!-- 🔔 Bell -->
            <div class="dropdown">
                <button class="btn btn-light btn-sm position-relative shadow-sm" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-bell"></i>

                    @if($notifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notifications->count() }}
                        </span>
                    @endif
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 320px;">
                    <li class="dropdown-header fw-bold text-dark">Blood Request Notifications</li>

                    @forelse($notifications as $notification)
                        <li>
                            <div class="dropdown-item-text border-bottom py-2">

                                <strong class="text-danger">Blood Request</strong><br>

                                <small>
                                    {{ $notification->hospital->name }} needs 
                                    <strong>{{ $notification->blood_type }}</strong> 
                                    ({{ $notification->quantity }})
                                </small>

                                <br>

                                <small>
                                    Urgency Level: {{ $notification->urgency_lvl }}
                                </small>
                                @if($notification->notes)
    <br>
    <small class="text-dark">
        <strong>Reason:</strong> {{ $notification->notes }}
    </small>
@endif

                                <br>

                                <small class="text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>

                            </div>
                        </li>
                    @empty
                        <li>
                            <div class="dropdown-item-text text-muted">No notifications yet.</div>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- SORT -->
            <form method="GET" action="{{ url('/blood-requests') }}">
                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Sort</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest to Oldest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest to Newest</option>
                </select>
            </form>

            <!-- NEW BUTTON -->
            <a href="#" class="btn bg-gradient-danger btn-sm mb-0"
               data-bs-toggle="modal"
               data-bs-target="#createBloodRequestModal">
                + New
            </a>

        </div>
    </div>
</div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Requester
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Location
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Blood Type
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Quantity
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Urgency Level
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Request Date
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Fulfilled By
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $dat)
                                    <tr class="{{ in_array($dat->id, $matchedIds ?? []) ? 'table-success' : '' }}">
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->id}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->hospital->name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->hospital->user->email}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{explode('|', $dat->hospital->location)[0]}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->blood_type}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->quantity}}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$dat->urgency_lvl}}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$dat->request_date->format('Y-m-d')}}</span>
                                        </td>
                                        <td class="text-center">
    @if($dat->status === 'Fulfilled')
        <span class="badge bg-success">Fulfilled</span>
    @elseif(in_array($dat->id, $matchedIds ?? []))
        <span class="badge bg-warning text-dark">Matched</span>
    @else
        <span class="badge bg-secondary">Pending</span>
    @endif
</td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$dat->confirmedBy ? $dat->confirmedBy->name : null }}</span>
                                        </td>
                                        <td class="text-center">
                                             @if(in_array($dat->id, $matchedIds ?? []) && $dat->status !== 'Fulfilled')
                                            <a 
    href="#"
    class="mx-3"
    data-bs-toggle="modal"
    data-bs-target="#fulfillBloodRequestModal"

    data-id="{{ $dat->id }}"


    data-request-hospital="{{ $dat->hospital->name }}"
    data-blood-type="{{ $dat->blood_type }}"
    data-quantity-requested="{{ $dat->quantity }}"
    data-urgency="{{ $dat->urgency_lvl }}"
    data-notes="{{ $dat->notes ?? 'No notes provided' }}"

    
    data-hospital="{{ $matchedDetails[$dat->id]['hospital_name'] ?? '' }}"
    data-blood="{{ $matchedDetails[$dat->id]['blood_type'] ?? '' }}"
    data-quantity="{{ $matchedDetails[$dat->id]['quantity'] ?? '' }}"
>
           <button class="btn btn-sm bg-gradient-danger mb-0">
    View Match
</button>
        </a>

    @elseif($dat->status === 'Fulfilled')

        <button class="btn btn-sm btn-success mb-0" disabled>
            Fulfilled
        </button>

    @else

        <button class="btn btn-sm btn-secondary mb-0" disabled title="Insufficient stock">
            Not Available
        </button>
        @if(isset($missingMap[$dat->id]))
    <div class="text-danger text-xs mt-1">
        Need +{{ $missingMap[$dat->id] }} more
    </div>
@endif

    @endif
                                            {{-- <span>
                                                <a
                                                    href="#"
                                                    class="mx-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteHospitalModal"
                                                    data-bs-original-title="Delete user"
                                                    data-id="{{ $dat->id }}"
                                                    data-name="{{ $dat->name }}"
                                                >
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </a>
                                            </span> --}}
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
</div>

<div class="modal fade" id="editAvailabilityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Edit Blood Availability</h5>
            </div>

            <form id="editAvailabilityForm" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Blood Type</label>
                        <input type="text" id="editBlood" name="blood_type" class="form-control" readonly>
                    </div>

                    <div class="mb-2">
                        <label>Quantity</label>
                        <input type="number" id="editQuantity" name="quantity" class="form-control" min="1" required>
                    </div>

                    <div class="mb-2">
                        <label>Status</label>
                        <select id="editStatus" name="status" class="form-control">
                            <option value="available">Available</option>
                            <option value="reserved">Reserved</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn bg-gradient-primary">Update</button>
                </div>

            </form>

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
.blood-request-bg {
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

/* 🔥 ADD THIS */
.availability-card {
    border-radius: 16px;
    transition: 0.2s ease;
}

.availability-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important;
}

</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {

    // ✅ FULFILL MODAL
    const fulfillBloodRequestModal = document.getElementById('fulfillBloodRequestModal');
    const fulfillBloodRequestForm = document.getElementById('fulfillBloodRequestForm');

    if (fulfillBloodRequestModal) {
        fulfillBloodRequestModal.addEventListener('show.bs.modal', event => {

            let button = event.relatedTarget;

            let id = button.getAttribute('data-id');
            let hospital = button.getAttribute('data-hospital');
            let blood = button.getAttribute('data-blood');
            let quantity = button.getAttribute('data-quantity');
            let requestHospital = button.getAttribute('data-request-hospital');
let bloodType = button.getAttribute('data-blood-type');
let quantityRequested = button.getAttribute('data-quantity-requested');
let urgency = button.getAttribute('data-urgency');
let notes = button.getAttribute('data-notes');

            fulfillBloodRequestForm.action = `/blood-requests/fulfill/${id}`;

            document.getElementById('matchHospital').textContent = hospital || 'N/A';
            document.getElementById('matchQuantity').textContent = quantity && blood ? `${quantity} (${blood})` : 'N/A';
            document.getElementById('matchRequestHospital').textContent = requestHospital || 'N/A';
document.getElementById('matchBloodType').textContent = bloodType || 'N/A';
document.getElementById('matchQuantityRequested').textContent = quantityRequested || 'N/A';
document.getElementById('matchUrgency').textContent = urgency || 'N/A';
document.getElementById('matchNotes').textContent = notes || 'No reason provided';
        });
    }

    // ✅ EDIT AVAILABILITY (SEPARATED FIX)
    document.querySelectorAll('.editAvailabilityBtn').forEach(button => {
        button.addEventListener('click', function () {

            let id = this.dataset.id;
            let blood = this.dataset.blood;
            let quantity = this.dataset.quantity;
            let status = this.dataset.status;

            document.getElementById('editBlood').value = blood;
            document.getElementById('editQuantity').value = quantity;
            document.getElementById('editStatus').value = status;

            document.getElementById('editAvailabilityForm').action = `/blood-availability/${id}`;
        });
    });

});
</script>
@endpush