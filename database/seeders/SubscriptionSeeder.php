<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            ['name' => 'Silver', 'price' => 500],
            ['name' => 'Gold', 'price' => 1000],
            ['name' => 'Platinum', 'price' => 2500],
        ];

        foreach ($plans as $plan) {
            Subscription::create([
                'user_id' => 10, // admin id (যদি database এ admin id 1 থাকে)
                'name'    => $plan['name'],
                'price'   => $plan['price'],
            ]);
        }
    }
}
