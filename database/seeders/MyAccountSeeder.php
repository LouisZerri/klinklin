<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Seeder;

class MyAccountSeeder extends Seeder
{
    /**
     * Données de test (commandes, articles, factures) pour le compte personnel.
     * Permet de tester les filtres (périodes/statuts), les factures et les transactions.
     */
    public function run(): void
    {
        $user = User::where('email', 'l.zerri@gmail.com')->first();

        if (! $user) {
            $this->command->warn("Compte l.zerri@gmail.com introuvable — MyAccountSeeder ignoré.");
            return;
        }

        $articles = Article::all()->keyBy('name');

        if ($articles->isEmpty()) {
            $this->call(ArticleSeeder::class);
            $articles = Article::all()->keyBy('name');
        }

        // [numéro, date, statut, [[article, quantité], ...]]
        $definitions = [
            ['#9001', '2024-02-10', 'Livré',                 [['Chemise', 3], ['Pantalon', 1]]],
            ['#9002', '2024-05-22', 'Terminée',              [['Pull', 2]]],
            ['#9003', '2024-08-15', 'Annulée',               [['Drap', 1], ['Housse de couette', 1]]],
            ['#9004', '2024-11-03', 'Livré',                 [['Costume', 1]]],
            ['#9005', '2025-01-18', 'Terminée',              [['Chemise', 5]]],
            ['#9006', '2025-03-09', 'Livré',                 [['Robe en soie', 2], ['Chemise', 1]]],
            ['#9007', '2025-06-27', 'Annulée',               [['Pantalon', 2]]],
            ['#9008', '2025-09-12', 'Collecté',              [['Drap', 2]]],
            ['#9009', '2025-12-01', 'En nettoyage',          [['Pull', 1], ['Chemise', 2]]],
            ['#9010', '2026-01-20', 'Sortir pour livraison', [['Housse de couette', 1]]],
            ['#9011', '2026-03-14', 'Prévu',                 [['Costume', 1], ['Chemise', 2]]],
            ['#9012', '2026-05-30', 'En attente',            [['Pantalon', 1]]],
            ['#9013', '2026-06-15', 'Livré',                 [['Chemise', 4], ['Pull', 1]]],
            ['#9014', '2026-06-25', 'Terminée',              [['Robe en soie', 1], ['Costume', 1]]],
        ];

        foreach ($definitions as [$number, $date, $status, $items]) {
            $order = Order::updateOrCreate(
                ['user_id' => $user->id, 'order_number' => $number],
                [
                    'address' => '8 rue Théodore Guilbeau',
                    'complement' => null,
                    'city' => 'Longueau',
                    'zip_code' => '80330',
                    'order_date' => $date,
                    'timeslot' => '08h00 - 10h00',
                    'status' => $status,
                    'subtotal' => 0,
                    'expedition' => 10,
                    'tax' => 5,
                ]
            );

            // (Re)création des lignes d'articles
            OrderItem::where('order_id', $order->id)->delete();
            $subtotal = 0;

            foreach ($items as [$name, $qty]) {
                $article = $articles[$name] ?? null;
                if (! $article) {
                    continue;
                }

                $ranges = $article->weight_ranges;
                $firstRange = is_array($ranges) ? reset($ranges) : [0.3, 0.5];
                $estimatedWeight = round((($firstRange[0] + $firstRange[1]) / 2) * $qty, 2);

                OrderItem::create([
                    'order_id' => $order->id,
                    'article_id' => $article->id,
                    'quantity' => $qty,
                    'estimated_weight' => $estimatedWeight,
                    'unit_price' => $article->unit_price,
                ]);

                $subtotal += $article->unit_price * $qty;
            }

            $order->update(['subtotal' => $subtotal]);

            // Facture (sauf commande non payée "En attente")
            if ($status !== 'En attente') {
                $this->generateInvoice($order->fresh('orderItems.article'), $user, $date);
            }
        }

        $this->command->info('MyAccountSeeder : ' . count($definitions) . ' commandes créées pour ' . $user->email);
    }

    private function generateInvoice(Order $order, User $user, string $date): void
    {
        $total = $order->subtotal + $order->expedition + $order->tax;

        $pdf = Pdf::loadView('invoices.invoice', [
            'order' => $order,
            'items' => $order->orderItems,
            'total' => $total,
        ]);

        $filename = 'invoice_' . $order->id . '.pdf';
        $pdf->save(storage_path('app/public/invoices/' . $filename));

        Invoice::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => $user->id,
                'reference' => 'INV-' . strtoupper(substr(md5($order->order_number), 0, 8)),
                'invoice_date' => $date,
                'total' => $total,
                'pdf_path' => 'invoices/' . $filename,
            ]
        );
    }
}
