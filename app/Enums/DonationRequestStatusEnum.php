<?php

namespace App\Enums;

enum DonationRequestStatusEnum: string
{
    case Pending = 'Pending';
    case Approved = 'Approved';
    case Cancelled = 'Cancelled';
}
