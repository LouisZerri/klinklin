<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InvoiceService
{
    /**
     * Génère (ou régénère) la facture PDF d'une commande et son enregistrement.
     *
     * @param  Carbon|string|null  $date  Date de facturation (par défaut : maintenant).
     */
    public function generateForOrder(Order $order, Carbon|string|null $date = null): Invoice
    {
        $order->loadMissing('orderItems.article');

        $items = $this->groupItemsByArticle($order);
        $total = $order->total;

        $filename = 'invoice_' . $order->id . '.pdf';
        $this->renderPdf($order, $items, $total)->save($this->path($filename));

        return Invoice::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => $order->user_id,
                'reference' => $this->reference($order),
                'invoice_date' => $date ?? Carbon::now(),
                'total' => $total,
                'pdf_path' => 'invoices/' . $filename,
            ]
        );
    }

    /**
     * Regroupe les lignes par article (fusionne les doublons).
     */
    private function groupItemsByArticle(Order $order)
    {
        return $order->orderItems->groupBy('article_id')->map(function ($items) {
            $first = $items->first();

            return (object) [
                'article' => $first->article,
                'quantity' => $items->sum('quantity'),
                'unit_price' => $first->unit_price,
                'total' => $items->sum(fn ($item) => $item->unit_price * $item->quantity),
            ];
        });
    }

    private function renderPdf(Order $order, $items, float $total)
    {
        return Pdf::loadView('invoices.invoice', [
            'order' => $order,
            'items' => $items,
            'total' => $total,
        ]);
    }

    /**
     * Référence stable et unique par commande (idempotente).
     */
    private function reference(Order $order): string
    {
        return 'INV-' . strtoupper(substr(md5($order->order_number . $order->id), 0, 8));
    }

    private function path(string $filename): string
    {
        $directory = storage_path('app/public/invoices');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        return $directory . '/' . $filename;
    }
}
