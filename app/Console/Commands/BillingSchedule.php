<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Component\Billing\DueDateCalculator;
use App\Models\Subscription;
use App\Models\Transaction;

class BillingSchedule extends Command
{
	protected $signature = 'nicehealth:billing';

	protected $description = 'Run billing schedule';

	private $dueDateCalculator = false;

	public function __construct(DueDateCalculator $dueDateCalculator)
	{
		parent::__construct();
		$this->dueDateCalculator = $dueDateCalculator;
	}

	public function handle()
	{
		// I assumed that "subscriptions can be paused" means that 
		// the subscription gets deactivated because of failed payment,
		// so let's check active subscriptions first 
		$activeSubscriptions = Subscription::where('active', true)->get();

		foreach ($activeSubscriptions as $subscription) {
			$nextDueDate = $this->dueDateCalculator->nextDueDate($subscription->created_at, Carbon::now());
			
			// first check if subscription is due today 
			if ($nextDueDate->diffInDays(Carbon::now()) === 0) {
				// let's make sure the subscription wasn't paid already this month
				$previousTransaction = Transaction::where('subscription_id', $subscription->id)->latest('created_at')->first();
				if ($previousTransaction->created_at->month == Carbon::now()->month) {
					if ($previousTransaction->status == 1) {
						continue;
					} 
				} // subscription wasn't paid last time so this won't be executed for it because 
				// for failed payments we set 'active' to false

				// simulate payment with 80% success rate
				$paymentStatus = rand(0,100) < 80 ? true : false;
				
				$transaction = new Transaction;
				$transaction->amount = $subscription->product->price;
				$transaction->status = $paymentStatus;
				$transaction->subscription_id = $subscription->id;

				$transaction->save();

				$subscription->active = $paymentStatus;
				$subscription->save();
			}
		}

		unset($activeSubscriptions);

		$inactiveSubscriptions = Subscription::where('active', false)->get();

		foreach ($inactiveSubscriptions as $subscription) {
			// we already know the payment failed last time (yesterday)
			// so we can go ahead and try once more immediately

			// simulate payment with 80% success rate
			$paymentStatus = rand(0,100) < 80 ? true : false;
				
			$transaction = new Transaction;
			$transaction->amount = $subscription->product->price;
			$transaction->status = $paymentStatus;
			$transaction->subscription_id = $subscription->id;

			$transaction->save();

			$subscription->active = $paymentStatus;
			$subscription->save();
		}
	}
}