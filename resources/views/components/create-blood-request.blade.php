<div class="modal fade" id="createBloodRequestModal" tabindex="-1" aria-labelledby="createBloodRequestLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="createBloodRequestLabel">Create New Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('blood-requests.store') }}">
            @csrf
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label for="blood_type" class="form-label">Blood Type</label>
                    <select class="form-control" id="blood_type" name="blood_type" required autocomplete="off">
                        <option value="" disabled selected>-- Select Blood Type --</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                    @error('blood_type') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="col-md-6">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required autocomplete="off">
                    @error('quantity') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="col-md-6">
                    <label for="urgency_lvl" class="form-label">Urgency Level</label>
                    <input type="number" class="form-control" id="urgency_lvl" name="urgency_lvl" required autocomplete="off" value="1" min="1" max="5">
                    @error('urgency_lvl') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn bg-gradient-primary">Confirm</button>
            </div>
        </form>
        <!-- End Form -->

        </div>
    </div>
</div>