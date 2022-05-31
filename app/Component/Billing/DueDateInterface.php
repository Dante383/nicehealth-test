<?php

namespace App\Component\Billing;

use Carbon\Carbon;

interface DueDateInterface
{
    public function periods(?Carbon $billingStartDate = null, ?Carbon $now = null): int;

    public function nextDueDate(?Carbon $billingStartDate = null, ?Carbon $now = null): Carbon;
}