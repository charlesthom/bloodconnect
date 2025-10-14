@extends('layouts.user_type.auth')

@section('content')

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
                {{-- approve reschedule request modal --}}
                <x-approve-reschedule-request />
                {{-- decline reschedule request modal --}}
                <x-decline-reschedule-request />
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Reschedule Requests</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#confirmCreateDonationRequestModal">+&nbsp; New</a>
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
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Location
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Scheduled Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Requested Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Requested Date Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $dat)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->id}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->user->name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->user->email}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{explode('|', $dat->user->location)[0]}}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->created_at->format('Y-m-d')}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->latestActiveSchedule?->date}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->latestActiveSchedule?->status}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->latestRescheduleRequest?->date}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->latestRescheduleRequest?->status}}</span>
                                    </td>
                                    <td class="text-center">
                                        <a 
                                            href="#"
                                            class="mx-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#approveRescheduleRequestModal"
                                            data-bs-original-title="Edit user"
                                            data-id="{{ $dat->latestRescheduleRequest?->id }}"
                                        >
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <span>
                                            <a
                                                href="#"
                                                class="mx-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#declineRescheduleRequestModal"
                                                data-bs-original-title="Delete user"
                                                data-id="{{ $dat->latestRescheduleRequest?->id }}"
                                            >
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </a>
                                        </span>
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
</style>
@endpush
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const approveRescheduleRequestModal = document.getElementById('approveRescheduleRequestModal');
    const approveRescheduleRequestForm = document.getElementById('approveRescheduleRequestForm');
    const declineRescheduleRequestModal = document.getElementById('declineRescheduleRequestModal');
    const declineRescheduleRequestForm = document.getElementById('declineRescheduleRequestForm');
    approveRescheduleRequestModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget; // the clicked button
        let id = button.getAttribute('data-id');

        approveRescheduleRequestForm.action = `/donation-requests/reschedule/approve/${id}`;
    });
    declineRescheduleRequestModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget; // the clicked button
        let id = button.getAttribute('data-id');

        declineRescheduleRequestForm.action = `/donation-requests/reschedule/decline/${id}`;
    });
});
</script>
@endpush
