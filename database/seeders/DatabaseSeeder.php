<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ArticleSeeder::class);

        $subscription = Subscription::firstOrCreate(
            ['name' => 'Standard'],
            [
                'price' => 0,
                'status' => 'active',
                'start_date' => now(),
            ]
        );

        Subscription::firstOrCreate(
            ['name' => 'Premium'],
            [
                'price' => 1990,
                'status' => 'active',
                'start_date' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'lastname' => 'Test',
                'firstname' => 'Utilisateur',
                'phone' => '+33600000000',
                'password' => Hash::make('password'),
                'subscription_id' => $subscription->id,
            ]
        );
    }
}
