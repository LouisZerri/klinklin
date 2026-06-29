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

        // Une seule formule payante : Premium. L'absence d'abonnement = offre gratuite.
        Subscription::updateOrCreate(
            ['name' => 'Premium'],
            [
                'price' => 999,
                'status' => 'active',
                'stripe_price_id' => config('stripe.premium_price_id'),
                'benefits' => [
                    'Livraison offerte sur chaque commande',
                    '−10 % sur chaque commande',
                    'Collecte prioritaire',
                    'Livraison express en 24h',
                    'Support client prioritaire',
                ],
                'start_date' => now(),
            ]
        );

        // On retire l'ancienne formule "Standard" si elle existe.
        Subscription::where('name', 'Standard')->delete();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'lastname' => 'Test',
                'firstname' => 'Utilisateur',
                'phone' => '+33600000000',
                'password' => Hash::make('password'),
                'subscription_id' => null,
            ]
        );

        $this->call(OrderSeeder::class);
        $this->call(MyAccountSeeder::class);
    }
}
