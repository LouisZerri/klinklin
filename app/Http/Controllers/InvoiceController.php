<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::id())->orderBy('invoice_date', 'asc')->get();

        return view("invoices.index", [
            'invoices' => $invoices
        ]);
    }

    /**
     * Télécharger toutes les factures dans une archive ZIP
     */
    public function downloadAll()
    {
        $userId = Auth::id();
        $invoices = Invoice::where('user_id', $userId)->get();

        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'Aucune facture disponible');
        }

        $zipFileName = 'factures_' . $userId . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($invoices as $invoice) {
                if ($invoice->pdf_path && Storage::disk('public')->exists($invoice->pdf_path)) {
                    $absolutePath = storage_path('app/public/' . $invoice->pdf_path);
                    $zip->addFile($absolutePath, 'facture_' . $invoice->id . '.pdf');
                }
            }
            $zip->close();
        } else {
            return redirect()->back()->with('error', 'Impossible de créer l\'archive ZIP');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

     /**
     * Télécharger une facture
     */
    public function download($id)
    {
        // Récupérer la facture
        $invoice = Invoice::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Vérifier que le fichier PDF existe
        if (!$invoice->pdf_path || !Storage::disk('public')->exists($invoice->pdf_path)) {
            abort(404, 'Fichier de facture introuvable');
        }

        // Chemin complet du fichier
        $filePath = storage_path('app/public/' . $invoice->pdf_path);

        // Nom du fichier pour le téléchargement
        $fileName = 'invoice_' . $invoice->id . '.pdf';

        // Retourner le fichier en téléchargement
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Visualiser une facture dans le navigateur (optionnel)
     */
    public function view($id)
    {
        // Récupérer la facture
        $invoice = Invoice::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Vérifier que le fichier PDF existe
        if (!$invoice->pdf_path || !Storage::disk('public')->exists($invoice->pdf_path)) {
            abort(404, 'Fichier de facture introuvable');
        }

        // Chemin complet du fichier
        $filePath = storage_path('app/public/' . $invoice->pdf_path);

        // Retourner le fichier pour visualisation dans le navigateur
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Facture_' . $invoice->reference . '.pdf"'
        ]);
    }

    /**
     * Vérifier si une facture existe et est accessible (pour AJAX)
     */
    public function checkAvailability($id)
    {
        try {
            $invoice = Invoice::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $exists = $invoice->pdf_path && Storage::disk('public')->exists($invoice->pdf_path);

            return response()->json([
                'available' => $exists,
                'filename' => $exists ? 'invoice_' . $invoice->id . '.pdf' : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'available' => false,
                'error' => 'Facture non trouvée'
            ], 404);
        }
    }
}
