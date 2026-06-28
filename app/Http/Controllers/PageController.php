<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Centre d'aide.
     */
    public function help()
    {
        return view('pages.help', [
            'topics' => [
                [
                    'emoji' => '👕',
                    'title' => 'Collecte & livraison',
                    'text' => "Planifiez une collecte, choisissez votre créneau et suivez l'avancement de votre commande jusqu'à la livraison.",
                ],
                [
                    'emoji' => '🧼',
                    'title' => 'Lavage & entretien',
                    'text' => "Découvrez comment vos textiles sont traités et quels articles peuvent être confiés à notre service.",
                ],
                [
                    'emoji' => '💳',
                    'title' => 'Paiement & factures',
                    'text' => "Moyens de paiement acceptés, sécurité des transactions et téléchargement de vos factures.",
                ],
                [
                    'emoji' => '👤',
                    'title' => 'Mon compte',
                    'text' => "Création de compte, mot de passe oublié, gestion de vos informations personnelles et de vos abonnements.",
                ],
            ],
            'faqs' => [
                ['q' => 'Comment planifier une collecte ?', 'r' => "Créez un compte, cliquez sur « Planifier une collecte », renseignez votre adresse puis choisissez vos articles et un créneau de passage."],
                ['q' => 'Quels sont les délais de livraison ?', 'r' => "Votre linge propre et repassé vous est retourné sous 48 heures ouvrées après la collecte."],
                ['q' => 'Puis-je annuler une collecte ?', 'r' => "Oui, jusqu'à 2 heures avant le créneau choisi, directement depuis votre espace personnel."],
                ['q' => 'Comment récupérer mes factures ?', 'r' => "Toutes vos factures sont disponibles au téléchargement dans la rubrique « Factures » de votre espace personnel."],
                ['q' => 'Mes paiements sont-ils sécurisés ?', 'r' => "Oui. Les paiements sont opérés via Stripe et vos coordonnées bancaires ne sont jamais stockées sur nos serveurs."],
            ],
        ]);
    }

    /**
     * Politique de confidentialité.
     */
    public function privacy()
    {
        return view('pages.legal', config('legal.privacy'));
    }

    /**
     * Termes et conditions.
     */
    public function terms()
    {
        return view('pages.legal', config('legal.terms'));
    }
}
