@extends('layouts.user_type.auth')

@section('content')

<div style="
  background: linear-gradient(135deg, #fff5f5, #ffe3e3);
  border-radius:20px;
  padding:20px;
">

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

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4" style="
              background: rgba(255,255,255,0.85);
              backdrop-filter: blur(8px);
              -webkit-backdrop-filter: blur(8px);
              border-radius:15px;
              box-shadow: 0 8px 25px rgba(0,0,0,0.08);
              border: 1px solid rgba(255,255,255,0.3);
            ">

                {{-- approve reschedule request modal --}}
                <x-approve-reschedule-request />

                {{-- decline reschedule request modal --}}
                <x-decline-reschedule-request />

                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Reschedule Requests</h5>
                            <p class="text-sm text-secondary mb-0">Manage reschedule requests</p>
                        </div>

                        <!-- 🔴 UPDATED BUTTON -->
                        <a href="#" 
   class="btn btn-sm mb-0"
   style="
     background: linear-gradient(135deg, #7b0000, #b30000);
     color:white;
     border:none;
     padding:6px 14px;
     font-size:12px;
     border-radius:8px;
     box-shadow: 0 3px 8px rgba(123,0,0,0.25);
   "
   data-bs-toggle="modal" 
   data-bs-target="#confirmCreateDonationRequestModal">
   + New
</a>

                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Creation Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Scheduled Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested Date Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $dat)
                                <tr>
                                    <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{$dat->id}}</p></td>
                                    <td><p class="text-xs font-weight-bold mb-0">{{$dat->user->name}}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{$dat->user->email}}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{explode('|', $dat->user->location)[0]}}</p></td>
                                    <td class="text-center"><span class="text-secondary text-xs font-weight-bold">{{$dat->created_at->format('Y-m-d')}}</span></td>
                                    <td class="text-center"><span class="text-secondary text-xs font-weight-bold">{{$dat->latestActiveSchedule?->date}}</span></td>
                                    <td class="text-center"><span class="text-secondary text-xs font-weight-bold">{{$dat->latestActiveSchedule?->status}}</span></td>
                                    <td class="text-center"><span class="text-secondary text-xs font-weight-bold">{{$dat->latestRescheduleRequest?->date}}</span></td>
                                    <td class="text-center"><span class="text-secondary text-xs font-weight-bold">{{$dat->latestRescheduleRequest?->status}}</span></td>
                                    <td class="text-center">
                                        <a href="#" class="mx-3"
                                           data-bs-toggle="modal"
                                           data-bs-target="#approveRescheduleRequestModal"
                                           data-id="{{ $dat->latestRescheduleRequest?->id }}">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <a href="#" class="mx-3"
                                           data-bs-toggle="modal"
                                           data-bs-target="#declineRescheduleRequestModal"
                                           data-id="{{ $dat->latestRescheduleRequest?->id }}">
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
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
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');
        approveRescheduleRequestForm.action = `/donation-requests/reschedule/approve/${id}`;
    });

    declineRescheduleRequestModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');
        declineRescheduleRequestForm.action = `/donation-requests/reschedule/decline/${id}`;
    });
});
</script>
@endpush