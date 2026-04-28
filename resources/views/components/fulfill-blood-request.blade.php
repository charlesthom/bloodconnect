<div class="modal fade" id="fulfillBloodRequestModal" tabindex="-1" aria-labelledby="fulfillBloodRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0" style="border-radius: 18px; overflow: hidden;">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 52px; height: 52px; background: #fde8e8; color: #b30000;">
                        <i class="fa-solid fa-droplet"></i>
                    </div>

                    <div>
                        <h5 class="modal-title font-weight-bold mb-1" id="fulfillBloodRequestModalLabel">
                            Matched Blood Request
                        </h5>
                        <small class="text-muted">
                            A blood request has been matched with your available blood.
                        </small>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="fulfillBloodRequestForm" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-body pt-4">

                    <h6 class="text-danger font-weight-bold mb-3">Request Details</h6>

                    <div class="p-3 mb-4" style="border: 1px solid #f3caca; border-radius: 14px; background: #fff7f7;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted">Requesting Hospital</small>
                                <div class="font-weight-bold" id="matchRequestHospital">N/A</div>
                            </div>

                            <div class="col-md-3">
                                <small class="text-muted">Blood Type</small>
                                <div class="font-weight-bold text-danger" id="matchBloodType">N/A</div>
                            </div>

                            <div class="col-md-3">
                                <small class="text-muted">Quantity Requested</small>
                                <div class="font-weight-bold text-danger" id="matchQuantityRequested">N/A</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted">Urgency Level</small>
                                <div class="font-weight-bold" id="matchUrgency">N/A</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted">Reason / Notes</small>
                                <div class="font-weight-bold" id="matchNotes">N/A</div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-success font-weight-bold mb-3">Your Availability</h6>

                    <div class="p-3 mb-4" style="border: 1px solid #cdebd5; border-radius: 14px; background: #f7fff9;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted">Your Hospital</small>
                                <div class="font-weight-bold" id="matchHospital">N/A</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted">Available Blood</small>
                                <div class="font-weight-bold text-success" id="matchQuantity">N/A</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3" style="border: 1px solid #ffd9a6; border-radius: 14px; background: #fff9ef;">
                        <small class="text-warning font-weight-bold">
                            By accepting this request, you confirm that you will fulfill the blood request using your available blood supply.
                        </small>
                    </div>

                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn text-white" style="background-color:#800000;">
                        Accept & Fulfill Request
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>