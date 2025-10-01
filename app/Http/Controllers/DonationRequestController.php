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

    public function show($id)
    {
        $request = $this->service->getById($id);
        return response()->json($request);
    }

    public function store(Request $request)
    {
        $this->service->create();
        return redirect()->back()->with('success', 'Request Created Successfully!');
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
