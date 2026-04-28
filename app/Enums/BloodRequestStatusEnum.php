<?php

namespace App\Enums;

enum BloodRequestStatusEnum: string
{
    case Pending = 'Pending';
    case Matched = 'Matched';
    case Fulfilled = 'Fulfilled';
}
