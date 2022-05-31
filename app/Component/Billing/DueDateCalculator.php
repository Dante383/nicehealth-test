<?php

namespace App\Component\Billing;

use Carbon\Carbon;
use Carbon\CarbonImmutable;

class DueDateCalculator implements DueDateInterface
{
    public function periods(?Carbon $billingStartDate = null, ?Carbon $now = null): int
    {
        $billingStartDate->startOfDay();
        $now->startOfDay();

        $difference = $billingStartDate->diffInMonths($now);

        if (($billingStartDate->day == $billingStartDate->daysInMonth) && ($now->day == $now->daysInMonth))
        {
            // 4 below is the magic number of difference in days indicating whether the difference in months 
            // should be increased by 1. this might not seem safe, but remember that this is an edge case
            // happening only when both of the dates are the last day of the month. this is the best
            // approach to the bug/unexpected behaviour of PHP's datetime I could think of
            if ($now->copy()->subMonthsNoOverflow($difference+1)->floatDiffInDays($billingStartDate) < 4) {
                $difference += 1;
            }
        }
        
        return $difference;
    }

    public function nextDueDate(?Carbon $billingStartDate = null, ?Carbon $now = null): Carbon
    {
        $difference = $billingStartDate->diffInMonths($now);

        $billingDate = $billingStartDate->addMonthsNoOverflow($difference+1);

        if ($billingDate->lte($now)) {
            if ($billingDate->day == $billingDate->daysInMonth){
                $billingDate = $billingDate->addMonthNoOverflow();
                $billingDate->day = $billingDate->daysInMonth;
            }
        }

        return $billingDate;
    }
}
