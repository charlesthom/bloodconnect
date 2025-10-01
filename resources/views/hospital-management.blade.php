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
                {{-- create hospital modal --}}
                <x-create-hospital />
                {{-- update hospital modal --}}
                <x-update-hospital />
                {{-- delete hospital modal --}}
                <x-delete-hospital />
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Hospitals</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#createHospitalModal">+&nbsp; New</a>
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
                                        Location
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Admin
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
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
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{explode('|', $dat->location)[0]}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->user->name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->user->email}}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->created_at->format('Y-m-d')}}</span>
                                    </td>
                                    <td class="text-center">
                                        <a 
                                            href="#"
                                            class="mx-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updateHospitalModal"
                                            data-bs-original-title="Edit user"
                                            data-id="{{ $dat->id }}"
                                            data-hospital-name="{{ $dat->name }}"
                                            data-location="{{ $dat->location }}"
                                            data-user-name="{{ $dat->user->name }}"
                                            data-user-id="{{ $dat->user->id }}"
                                            data-user-email="{{ $dat->user->email }}"
                                            data-user-birth-date="{{ $dat->user->birth_date }}"
                                            data-user-gender="{{ $dat->user->gender }}"
                                            data-user-phone="{{ $dat->user->phone }}"
                                            data-user-status="{{ $dat->user->status }}"
                                        >
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <span>
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
// document.addEventListener("DOMContentLoaded", function () {
//     const modal = document.getElementById('createHospitalModal');

//     modal.addEventListener('shown.bs.modal', function () {
//         console.log('andre');

//         if (navigator.geolocation) {
//             navigator.geolocation.getCurrentPosition(
//                 function (position) {
//                     const lat = position.coords.latitude;
//                     const lon = position.coords.longitude;
//                     console.log(position.location);
//                     document.getElementById('location-status').innerText =
//                         "Latitude: " + lat +
//                         ", Longitude: " + lon;
//                     document.getElementById('user_location').value = lat + ',' + lon;
//                 },
//                 function (error) {
//                     document.getElementById('location-status').innerText =
//                         "Error: " + error.message;
//                 }
//             );
//         } else {
//             document.getElementById('location-status').innerText =
//                 "Geolocation is not supported by this browser.";
//         }
//     });
// });
async function geocodeAddress(method) {
    let address = null;
    console.log(method);
    if (method === 'create') {
        address = document.getElementById("address").value;
    } else {
        address = document.getElementById("update_address").value;
    }

    if (!address) {
        alert("Please enter an address");
        return;
    }

    // Call Nominatim API
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`;

    try {
        const response = await fetch(url, {
            headers: {
                "User-Agent": "BloodConnect (admin@bloodconnect.com)", // Nominatim requires identifying headers
            }
        });
        const data = await response.json();

        if (data.length > 0) {
            const lat = data[0].lat;
            const lon = data[0].lon;

            const formatted = address + '|' + lat + '|' + lon;
            if (method === 'create') {
                document.getElementById('hospital_location').value = formatted;
                document.getElementById("result").innerHTML = `
                    <p><b>Latitude:</b> ${lat}</p>
                    <p><b>Longitude:</b> ${lon}</p>
                `;
            } else {
                document.getElementById('update_hospital_location').value = formatted;
                document.getElementById("update_result").innerHTML = `
                    <p><b>Latitude:</b> ${lat}</p>
                    <p><b>Longitude:</b> ${lon}</p>
                `;
            }
        } else {
            document.getElementById("result").innerHTML = `<p>No results found.</p>`;
            document.getElementById('hospital_location').value = null;
            document.getElementById('update_hospital_location').value = null;
        }
    } catch (error) {
        console.error(error);
        alert("Error fetching location data");
    }
}
document.addEventListener("DOMContentLoaded", () => {
    const updateModal = document.getElementById('updateHospitalModal');
    const updateForm = document.getElementById('updateHospitalForm');
    const deleteModal = document.getElementById('deleteHospitalModal');
    const deleteForm = document.getElementById('deleteHospitalForm');

    updateModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget; // the clicked button
        let id = button.getAttribute('data-id');
        let hospital_name = button.getAttribute('data-hospital-name');
        let location = button.getAttribute('data-location');
        let user_id = button.getAttribute('data-user-id');
        let user_name = button.getAttribute('data-user-name');
        let user_email = button.getAttribute('data-user-email');
        let user_birth_date = button.getAttribute('data-user-birth-date');
        let user_gender = button.getAttribute('data-user-gender');
        let user_phone = button.getAttribute('data-user-phone');
        let user_status = button.getAttribute('data-user-status');
        console.log(user_status);

        // assign to modal inputs
        document.getElementById('update_hospital_id').value = id;
        document.getElementById('update_hospital_name').value = hospital_name;
        document.getElementById('update_hospital_location').value = location;
        document.getElementById('update_user_id').value = user_id;
        document.getElementById('update_user_name').value = user_name;
        document.getElementById('update_user_email').value = user_email;
        document.getElementById('update_user_birth_date').value = user_birth_date;
        document.getElementById('update_user_gender').value = user_gender;
        document.getElementById('update_user_phone').value = user_phone;
        document.getElementById('update_user_status').value = user_status;

        // add the form action dynamically
        updateForm.action = `/hospitals/${id}`;
    });
    deleteModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget; // the clicked button
        let id = button.getAttribute('data-id');
        let name = button.getAttribute('data-name');

        // assign to modal inputs
        document.getElementById('delete_hospital_name').innerHTML = 'Are you sure you want to delete ' + name + '?';

        // add the form action dynamically
        deleteForm.action = `/hospitals/${id}`;
    });
});
</script>
@endpush

