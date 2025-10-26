<?php

namespace App\Http\Controllers;

use App\Services\DonationRequestService;
use Illuminate\Http\Request;

class DonationRequestController extends Controller
{
    protected $service;

    public function __construct(DonationRequestService $service)
    {
        $this->service = $service;
    }

    public function index()
    {

        return view('donation-requests')->with([
            "data" => $this->service->getAll()
        ]);
    }

    public function donor()
    {
        return view('donation-requests')->with([
            "data" => $this->service->getAllByDonor()
        ]);
    }

    public function hospital()
    {
        return view('donation-requests-hospital')->with([
            "data" => $this->service->getAllByHospital()
        ]);
    }

    public function showReschedule()
    {
        // return $this->service->getAllRescheduleByHospital();
        return view('donation-reschedule-requests')->with([
            "data" => $this->service->getAllRescheduleByHospital()
        ]);
    }

    public function show($id)
    {
        $request = $this->service->getById($id);
        return response()->json($request);
    }

    public function store(Request $request)
    {
        try {
            $this->service->create();
            return redirect()->back()->with('success', 'Request Created Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'sometimes|date',
            'location' => 'sometimes|string',
            'notes' => 'nullable|string',
            'status' => 'sometimes|string',
            'scheduled_date' => 'nullable|date',
        ]);

        $request = $this->service->update($id, $data);
        return response()->json($request);
    }

    public function approve(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $this->service->approve($id, $data);
        return redirect()->back()->with('success', 'Request Approved Successfully!');
    }

    public function reschedule(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $this->service->reschedule($id, $data);
        return redirect()->back()->with('success', 'Submitted Reschedule Request Successfully!');
    }

    public function approveReschedule($id)
    {
        $this->service->approveReschedule($id);
        return redirect()->back()->with('success', 'Approved Reschedule Request Successfully!');
    }

    public function declineReschedule($id)
    {
        $this->service->declineReschedule($id);
        return redirect()->back()->with('success', 'Declined Reschedule Request Successfully!');
    }

    public function cancel($id)
    {
        $this->service->cancel($id);
        return redirect()->back()->with('success', 'Request Cancelled Successfully!');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
