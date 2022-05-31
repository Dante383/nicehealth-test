<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class CarbonMacrosServiceProvider extends ServiceProvider
{
	public function boot()
	{
	}

	public function register()
	{
		Carbon::macro('thisDayOrLast', function ($day) {
		    $last = $this->copy()->lastOfMonth();

		    $this->day = ($day > $last->day) ? $last->day : $day;

		    return $this;
		});
	}
}