<div class="modal fade" id="declineRescheduleRequestModal" tabindex="-1" aria-labelledby="declineRescheduleRequestModalLable" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="declineRescheduleRequestModalLable">Decline Reschedule Request?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form id="declineRescheduleRequestForm" method="POST">
            @csrf
            @method('PATCH')
            <form id="declineRescheduleRequestForm" method="POST">
    @csrf
    @method('PATCH')

    <div class="modal-body row g-1">
        <div class="col-md-12">
            <label for="decline_reschedule_notes" class="form-label">Reason / Notes</label>
            <textarea
                class="form-control"
                id="decline_reschedule_notes"
                name="notes"
                rows="3"
                placeholder="Enter reason for declining the reschedule request"
                required></textarea>
        </div>
    </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn text-white" style="background-color:#800000;">Yes</button>
            </div>
        </form>
        <!-- End Form -->

        </div>
    </div>
</div>