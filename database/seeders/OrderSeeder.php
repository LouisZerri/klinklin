<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Commandes de démonstration pour alimenter la page Historique.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if (! $user) {
            return;
        }

        // Montant payé = subtotal (expédition et taxe à 0 pour un total net affiché).
        $orders = [
            ['number' => '#8233', 'date' => '2025-07-09', 'amount' => 15.00, 'status' => 'Annulée'],
            ['number' => '#0618', 'date' => '2025-05-23', 'amount' => 199.00, 'status' => 'Annulée'],
            ['number' => '#2319', 'date' => '2025-04-25', 'amount' => 347.99, 'status' => 'Annulée'],
            ['number' => '#7129', 'date' => '2025-04-15', 'amount' => 77.00, 'status' => 'Terminée'],
            ['number' => '#2095', 'date' => '2025-04-12', 'amount' => 229.00, 'status' => 'Terminée'],
            ['number' => '#6503', 'date' => '2025-04-09', 'amount' => 269.00, 'status' => 'Terminée'],
            ['number' => '#8678', 'date' => '2025-03-02', 'amount' => 216.98, 'status' => 'Annulée'],
            ['number' => '#3787', 'date' => '2025-03-01', 'amount' => 79.00, 'status' => 'Terminée'],
        ];

        foreach ($orders as $order) {
            Order::updateOrCreate(
                ['user_id' => $user->id, 'order_number' => $order['number']],
                [
                    'address' => '12 rue de la Blanchisserie',
                    'complement' => null,
                    'city' => 'Paris',
                    'zip_code' => '75011',
                    'order_date' => $order['date'],
                    'timeslot' => '09:00 - 12:00',
                    'status' => $order['status'],
                    'subtotal' => $order['amount'],
                    'expedition' => 0,
                    'tax' => 0,
                ]
            );
        }
    }
}
