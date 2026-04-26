<?php

namespace App\Repositories;

use App\Models\Hospital;
use App\Repositories\Contracts\HospitalRepositoryInterface;

class HospitalRepository implements HospitalRepositoryInterface
{
    public function create(array $data): Hospital
    {
        return Hospital::create($data);
    }

    public function update(array $data): bool
    {
        return Hospital::where('id', $data['hospital_id'])
            ->update([
                'name' => $data['name'],
                'location' => $data['location'],
            ]);
    }

    public function delete(int $id): int
    {
        return Hospital::where('id', $id)->delete();
    }

    public function getAll()
    {
        // eager load user since it's one-to-one
        return Hospital::with('user')->get();
    }

    public function findById(int $id)
    {
        return Hospital::with('user')->findOrFail($id);
    }

   private function getBarangayAndCity(string $location): array
{
    $cleanLocation = strtolower(explode('|', $location)[0]);
    $parts = array_map('trim', explode(',', $cleanLocation));

    return [
        'barangay' => $parts[0] ?? '',
        'city' => $this->normalizeCity($parts[1] ?? ''),
    ];
}

private function normalizeCity(string $city): string
{
    $city = strtolower(trim($city));

    if (str_contains($city, 'mandaue')) return 'mandaue city';
    if (str_contains($city, 'danao')) return 'danao city';
    if (str_contains($city, 'lapu')) return 'lapu-lapu city';
    if (str_contains($city, 'toledo')) return 'toledo city';
    if (str_contains($city, 'bogo')) return 'bogo city';
    if (str_contains($city, 'talisay')) return 'talisay city';
    if (str_contains($city, 'cebu')) return 'cebu city';

    return $city;
}

public function findNearestHospital($location)
{
    $hospitals = $this->findNearbyHospitals($location);

    return $hospitals->first();
}

public function findNearbyHospitals($location)
{
    $userLocation = $this->getBarangayAndCity($location);

    $sameBarangayHospitals = Hospital::get()->filter(function ($hospital) use ($userLocation) {
        $hospitalLocation = $this->getBarangayAndCity($hospital->location);

        return $hospitalLocation['barangay'] === $userLocation['barangay']
            && $hospitalLocation['city'] === $userLocation['city'];
    });

    if ($sameBarangayHospitals->count() > 0) {
        return $sameBarangayHospitals->values();
    }

    $sameCityHospitals = Hospital::get()->filter(function ($hospital) use ($userLocation) {
        $hospitalLocation = $this->getBarangayAndCity($hospital->location);

        return $hospitalLocation['city'] === $userLocation['city'];
    });

    if ($sameCityHospitals->count() > 0) {
        return $sameCityHospitals->values();
    }

   return Hospital::get();
}
}