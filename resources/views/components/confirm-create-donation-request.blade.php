<div class="modal fade" id="confirmCreateDonationRequestModal" tabindex="-1" aria-labelledby="confirmCreateDonationRequestLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="confirmCreateDonationRequestLabel">Confirm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form method="POST" action="/donation-requests">
            @csrf
            <div class="modal-body row g-1">
                <div id="delete_hospital_name">Confirm creation of new donation request?</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn bg-gradient-primary">Yes</button>
            </div>
        </form>
        <!-- End Form -->

        </div>
    </div>
</div>