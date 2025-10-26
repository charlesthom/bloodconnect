<?php

namespace App\Http\Controllers;

use App\Services\BloodRequestService;
use App\Services\DashboardService;
use App\Services\DonationRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $service;
    protected $donationRequestService;
    protected $bloodRequestService;

    public function __construct(
        DashboardService $service,
        DonationRequestService $donationRequestService,
        BloodRequestService $bloodRequestService,
    ) {
        $this->service = $service;
        $this->donationRequestService = $donationRequestService;
        $this->bloodRequestService = $bloodRequestService;
    }
    public function index()
    {
        switch (Auth::User()->role->value) {
            case 'donor':
                $latestActive = $this->service->findLatestActiveDonation();
                $latest = $this->service->findLatestDonationRequest();
                $all = $this->service->findAllByDonor();
                $allScheduled = $this->service->findAllScheduledByDonor();
                return view('donor-dashboard')->with([
                    'latest' => $latest,
                    'latest_active' => $latestActive,
                    'all_count' => $all->count(),
                    'all_scheduled_count' => $allScheduled->count(),
                ]);
                break;
            case 'hospital':
                $donationRequests = $this->donationRequestService->getAllByHospital();
                $rescheduleRequests = $this->donationRequestService->getAllRescheduleByHospital();
                $allBloodRequests = $this->bloodRequestService->getAll();
                $bloodRequests = $this->bloodRequestService->getAllByHospital();
                return view('hospital-dashboard')->with([
                    'pending_count' => $donationRequests->count(),
                    'reschedule_count' => $rescheduleRequests->count(),
                    'blood_request_count' => $bloodRequests->count(),
                    'all_blood_request_count' => $allBloodRequests->count(),
                ]);
                break;
            default:
                return view('dashboard');
                break;
        }
    }

    public function hospitalData()
    {
        $data = $this->donationRequestService->getMonthlyDataThisYearByHospital();
        $accepted_data = $this->donationRequestService->getMonthlyAcceptedDataThisYearByHospital();
        $mapped_data = $data->map(function ($item) {
            $item['month_name'] = \Carbon\Carbon::create()->month($item['month'])->format('M');
            return $item;
        });
        $accepted_mapped_data = $accepted_data->map(function ($item) {
            $item['month_name'] = \Carbon\Carbon::create()->month($item['month'])->format('M');
            return $item;
        });
        return (object) [
            'total_requests' => $mapped_data,
            'total_accepted_requests' => $accepted_mapped_data
        ];
    }
}
