<?php

namespace App\Http\Controllers;

use App\Models\BloodAvailability;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BloodAvailabilityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'blood_type' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        $user = Auth::user();
        $hospital = Hospital::where('user_id', $user->id)->first();

        $existing = BloodAvailability::where('hospital_id', $hospital->id)
    ->where('blood_type', $request->blood_type)
    ->where('status', 'available')
    ->first();

if ($existing) {
    $existing->quantity += (int) $request->quantity;
    $existing->save();
} else {
    BloodAvailability::create([
        'hospital_id' => $hospital->id,
        'blood_type' => $request->blood_type,
        'quantity' => $request->quantity,
        'status' => 'available',
    ]);
}

        return back()->with('success', 'Blood availability added!');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'blood_type' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'status' => 'required|string',
    ]);

    $availability = BloodAvailability::findOrFail($id);

    $user = Auth::user();
    $hospital = Hospital::where('user_id', $user->id)->first();

    if ($availability->hospital_id != $hospital->id) {
        abort(403);
    }

    $availability->update([
        'blood_type' => $request->blood_type,
        'quantity' => $request->quantity,
        'status' => $request->status,
    ]);

    return back()->with('success', 'Blood availability updated!');
}
    public function destroy($id)
{
    $availability = BloodAvailability::findOrFail($id);

    $user = Auth::user();
    $hospital = Hospital::where('user_id', $user->id)->first();

    // security: only own record
    if ($availability->hospital_id != $hospital->id) {
        abort(403);
    }

    $availability->delete();

    return back()->with('success', 'Blood availability deleted!');
}
}