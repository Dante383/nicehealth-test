<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscription = new Subscription();
        $subscription->customer_id = 1;
        $subscription->product_id = 1;
        $subscription->active = true;
        $subscription->save();
    }
}
