<?php

namespace App\Http\Controllers;

use App\Services\BloodRequestService;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    protected $service;

    public function __construct(BloodRequestService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        // return $this->service->getAll();
        return view('blood-requests')->with([
            "data" => $this->service->getAll()
        ]);
    }

    public function show($id)
    {
        $request = $this->service->getById($id);
        return response()->json($request);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hospital_id'   => 'required|exists:hospitals,id',
            'blood_type'    => 'required|string',
            'quantity'      => 'required|string',
            'urgency_lvl'   => 'required|string',
            'request_date'  => 'required|date',
            'confirmed_by'  => 'nullable|exists:users,id',
            'status'        => 'required|string',
        ]);
        $this->service->create($validated);
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

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
