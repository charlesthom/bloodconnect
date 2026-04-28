<?php

namespace App\Http\Controllers;

use App\Services\BloodRequestService;
use Illuminate\Http\Request;
use App\Models\BloodAvailability;
use App\Models\Hospital;
use Illuminate\Support\Facades\Auth;

class BloodRequestController extends Controller
{
    protected $service;

    public function __construct(BloodRequestService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
{
    $data = collect($this->service->getAll())
        ->sortBy('request_date')
        ->values();

    if ($request->sort == 'newest') {
        $data = collect($data)->sortByDesc(function ($item) {
            return $item->request_date;
        })->values();
    }

    if ($request->sort == 'oldest') {
        $data = collect($data)->sortBy(function ($item) {
            return $item->request_date;
        })->values();
    }

    $matchedNotifications = collect();

    $user = Auth::user();
    $hospital = Hospital::where('user_id', $user->id)->first();

    if ($hospital) {
        $availabilities = BloodAvailability::where('hospital_id', $hospital->id)
            ->where('status', 'available')
            ->get();

        $matchedNotifications = $data->filter(function ($item) use ($availabilities, $hospital) {
            if ($item->hospital_id == $hospital->id) {
                return false;
            }

            if ($item->status === 'Fulfilled') {
    return false;
}

            return $availabilities->contains(function ($availability) use ($item) {
                return $availability->blood_type === $item->blood_type
                    && (int) $availability->quantity >= (int) $item->quantity;
            });
        })->sortByDesc('created_at')->values();
    }

    $myAvailabilities = collect();

    if ($hospital) {
        $myAvailabilities = BloodAvailability::where('hospital_id', $hospital->id)
            ->latest()
            ->get();
    }
$matchedIds = $matchedNotifications->pluck('id')->toArray();
    return view('blood-requests')->with([
        "data" => $data,
        "matchedNotifications" => $matchedNotifications,
        "myAvailabilities" => $myAvailabilities,
        "matchedIds" => $matchedIds,
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
    'blood_type'    => 'required|string',
    'quantity'      => 'required|integer',
    'urgency_lvl'   => 'required|string',
    'notes'         => 'nullable|string',
]);
        $this->service->create($validated);
        return redirect()->back()->with('success', 'Request Created Successfully!');
    }

    public function fulfill($id)
    {
        $this->service->fulfill($id);
        return redirect()->back()->with('success', 'Fulfilled Blood Request Successfully!');
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
