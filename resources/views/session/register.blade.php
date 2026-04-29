@extends('layouts.user_type.guest')

@section('content')

<section class="min-vh-100 mb-8">

  <!-- HEADER -->
  <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg"
       style="background-image: linear-gradient(rgba(90,10,10,0.55), rgba(122,15,26,0.70)), url('/assets/img/hospital-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <span class="mask bg-gradient-dark opacity-6"></span>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center mx-auto">

          <!-- 🔥 TITLE ONLY (NO LOGO) -->
          <h1 class="text-white mb-2 mt-4 text-center"
              style="font-weight:900; font-size:48px; letter-spacing:1px; text-shadow: 0px 4px 10px rgba(0,0,0,0.4);">
            Blood<span style="color:#ff4d4d;">Connect</span>
          </h1>

          <p class="text-white text-center mb-0" style="font-size:18px;">
            Create your account and help save lives.
          </p>

        </div>
      </div>
    </div>
  </div>

  <!-- FORM -->
  <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
      <div class="col-xl-5 col-lg-6 col-md-8 mx-auto">

        <div class="card shadow-lg" style="border-radius:20px; border:none;">

          <div class="card-header text-center pt-4 bg-transparent">
            <h4 style="color:#7b0f1a; font-weight:700;">Donor Registration</h4>
          </div>

          <div class="card-body">
            <form method="POST" action="/register">
              @csrf

              <select id="province" class="form-control" required>
  <option value="">Select Province</option>
</select>

<select id="city" class="form-control mt-2" required>
  <option value="">Select City / Municipality</option>
</select>

<select id="barangay" class="form-control mt-2" required>
  <option value="">Select Barangay</option>
</select>

              <!-- NAME -->
              <div class="mb-3">
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Name"
                       value="{{ old('name') }}">
                @error('name')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- EMAIL -->
              <div class="mb-3">
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Email"
                       value="{{ old('email') }}">
                @error('email')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- PASSWORD -->
              <div class="mb-3">
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Password">
                @error('password')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- BIRTHDATE -->
              <div class="mb-3">
                <input type="date"
                       name="birth_date"
                       class="form-control"
                       value="{{ old('birth_date') }}">
                @error('birth_date')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- GENDER -->
              <div class="mb-3">
                <select name="gender" class="form-control">
                  <option value="">-- Select Gender --</option>
                  <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                  <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- PHONE -->
              <div class="mb-3">
                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="Phone Number"
                       value="{{ old('phone') }}">
                @error('phone')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- LOCATION -->
              <div class="mb-3">
                <input type="text"
                       name="location"
                       id="location"
                       class="form-control"
                       placeholder="Location"
                       value="{{ old('location') }}"
                       readonly
                       required>
                @error('location')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- AGREEMENT -->
              <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       name="agreement"
                       {{ old('agreement') ? 'checked' : '' }}>
                <label class="form-check-label">
                  I agree to Terms and Conditions
                </label>
                @error('agreement')
                  <p class="text-danger text-xs">Please accept terms</p>
                @enderror
              </div>

              <!-- SUBMIT -->
              <div class="text-center">
                <button type="submit"
                        class="btn bg-gradient-dark w-100 my-4"
                        style="background: linear-gradient(135deg,#7b0f1a,#a31521,#c1121f); color:white; border:none;">
                  Sign Up
                </button>
              </div>

              <p class="text-sm text-center">
                Already have an account?
                <a href="{{ route('login') }}">Sign in</a>
              </p>

            </form>
          </div>

        </div>

      </div>
    </div>
  </div>

</section>

<!-- SCRIPT -->
<script>
const provinceSelect = document.getElementById("province");
const citySelect = document.getElementById("city");
const brgySelect = document.getElementById("barangay");
const locationInput = document.getElementById("location");

provinceSelect.innerHTML = '<option value="">Select Province</option>';
citySelect.innerHTML = '<option value="">Select City / Municipality</option>';
brgySelect.innerHTML = '<option value="">Select Barangay</option>';
locationInput.value = "";

// Load Cebu Province only
fetch("https://psgc.gitlab.io/api/provinces/")
  .then(response => response.json())
  .then(provinces => {
    const cebu = provinces.find(province => province.name.toLowerCase() === "cebu");

    if (!cebu) {
      alert("Cebu province not found.");
      return;
    }

    provinceSelect.add(new Option(cebu.name, cebu.code));
    provinceSelect.value = cebu.code;

    loadCities(cebu.code);
  })
  .catch(() => {
    alert("Unable to load provinces. Please check your internet connection.");
  });

// Load Cebu cities/municipalities
function loadCities(provinceCode) {
  citySelect.innerHTML = '<option value="">Select City / Municipality</option>';
  brgySelect.innerHTML = '<option value="">Select Barangay</option>';
  locationInput.value = "";

  fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`)
    .then(response => response.json())
    .then(cities => {
      cities.sort((a, b) => a.name.localeCompare(b.name));

      cities.forEach(city => {
  let option = new Option(city.name, city.name);
  option.setAttribute("data-code", city.code);
  citySelect.add(option);
});
    })
    .catch(() => {
      alert("Unable to load cities/municipalities.");
    });
}

// Load barangays when city changes
citySelect.addEventListener("change", function () {
  const selectedOption = citySelect.options[citySelect.selectedIndex];
  const cityCode = selectedOption.getAttribute("data-code");

  brgySelect.innerHTML = '<option value="">Select Barangay</option>';
  locationInput.value = "";

  if (!cityCode) return;

  fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays/`)
    .then(response => response.json())
    .then(barangays => {
      barangays.sort((a, b) => a.name.localeCompare(b.name));

      barangays.forEach(barangay => {
        brgySelect.add(new Option(barangay.name, barangay.name));
      });
    })
    .catch(() => {
      alert("Unable to load barangays.");
    });
});

// Set location when barangay changes
brgySelect.addEventListener("change", function () {
  const brgy = this.value;
  const cityName = citySelect.value;

  if (!brgy || !cityName) {
    locationInput.value = "";
    return;
  }

  locationInput.value = `${brgy}, ${cityName}, Cebu`;
});
</script>

@endsection