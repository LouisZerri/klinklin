<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FeatureController extends Controller
{
    /**
     * Contenu des pages "En savoir plus" présentées sur la page d'accueil.
     */
    private function features(): array
    {
        return [
            'collecte-de-vetements' => [
                'emoji' => '👕',
                'title' => 'Collecte de vêtements',
                'lead' => "Ne perdez plus de temps à vous déplacer : nous venons chercher votre linge directement chez vous ou sur votre lieu de travail, sans frais supplémentaires.",
                'points' => [
                    ['title' => 'Choisissez votre créneau', 'text' => "Sélectionnez le jour et la plage horaire qui vous arrangent depuis votre espace personnel. Un coursier passe récupérer votre linge à l'adresse de votre choix."],
                    ['title' => 'Aucun déplacement', 'text' => "Domicile, bureau ou point relais : nous nous adaptons à votre quotidien pour que le pressing vienne à vous, et non l'inverse."],
                    ['title' => 'Suivi en temps réel', 'text' => "Vous êtes notifié à chaque étape, de la prise en charge de votre linge jusqu'à sa restitution."],
                ],
                'closing' => "La collecte est sans engagement et incluse dans nos tarifs. Planifiez votre première commande en quelques clics.",
            ],
            'lavage-professionnel' => [
                'emoji' => '🧼',
                'title' => 'Lavage professionnel',
                'lead' => "Chaque vêtement est traité avec soin selon ses besoins : lavage à la main, nettoyage doux ou pressing, avec des machines et des produits de qualité professionnelle.",
                'points' => [
                    ['title' => 'Un traitement adapté', 'text' => "Nos équipes identifient la matière et l'étiquette d'entretien de chaque pièce pour appliquer le programme le plus adapté, du coton robuste à la soie délicate."],
                    ['title' => 'Soin des textiles délicats', 'text' => "Robes en soie, costumes et pièces fragiles bénéficient d'un nettoyage à sec ou d'un lavage main réalisé par des professionnels."],
                    ['title' => 'Repassage soigné', 'text' => "Vos vêtements vous reviennent propres, pliés et repassés, prêts à être rangés ou portés immédiatement."],
                ],
                'closing' => "Confiez-nous vos textiles les plus précieux : nous en prenons soin comme s'ils étaient les nôtres.",
            ],
            'livraison-rapide' => [
                'emoji' => '🚚',
                'title' => 'Livraison rapide',
                'lead' => "Votre linge propre et repassé vous est retourné en seulement deux jours. Fini les longues attentes !",
                'points' => [
                    ['title' => 'Livré en 48h', 'text' => "Dès la collecte effectuée, votre commande est traitée en priorité pour un retour sous 48 heures ouvrées."],
                    ['title' => 'Au créneau qui vous convient', 'text' => "Vous choisissez l'horaire de livraison, comme pour la collecte. Plus besoin d'attendre toute une journée."],
                    ['title' => 'Emballage protecteur', 'text' => "Votre linge est restitué protégé et soigneusement plié, à l'abri de la poussière et des plis."],
                ],
                'closing' => "Un service pensé pour votre emploi du temps, du ramassage à la livraison.",
            ],
            'paiement-securise' => [
                'emoji' => '💳',
                'title' => 'Paiement sécurisé',
                'lead' => "Payez en toute tranquillité par carte bancaire. Toutes les transactions sont chiffrées et protégées.",
                'points' => [
                    ['title' => 'Transactions chiffrées', 'text' => "Les paiements sont opérés via Stripe, leader mondial du paiement en ligne. Vos coordonnées bancaires ne transitent jamais en clair par nos serveurs."],
                    ['title' => 'Facture automatique', 'text' => "Une facture détaillée est générée pour chaque commande et reste disponible au téléchargement dans votre espace personnel."],
                    ['title' => 'Aucune mauvaise surprise', 'text' => "Le montant est calculé et affiché avant le paiement : vous savez exactement ce que vous réglez."],
                ],
                'closing' => "Sécurité, transparence et simplicité : commandez en toute sérénité.",
            ],
            'option-abonnement' => [
                'emoji' => '📦',
                'title' => 'Option abonnement',
                'lead' => "Choisissez la solution qui vous convient : optez pour un abonnement régulier ou payez à chaque commande, selon vos besoins.",
                'points' => [
                    ['title' => 'À la carte', 'text' => "Pas envie de vous engager ? Commandez ponctuellement et payez uniquement ce que vous utilisez."],
                    ['title' => 'Formule régulière', 'text' => "Pour les besoins récurrents, l'abonnement vous fait bénéficier de collectes planifiées et de tarifs avantageux."],
                    ['title' => 'Modifiable à tout moment', 'text' => "Changez de formule, mettez en pause ou résiliez quand vous le souhaitez, sans frais cachés."],
                ],
                'closing' => "Une flexibilité totale pour s'adapter à votre rythme de vie.",
            ],
            'produits-respectueux' => [
                'emoji' => '🌱',
                'title' => 'Produits respectueux',
                'lead' => "Nous privilégions des lessives écologiques, biodégradables et sans produits agressifs, pour le respect de votre peau et de la planète.",
                'points' => [
                    ['title' => 'Lessives écologiques', 'text' => "Nos produits sont biodégradables et certifiés, sans substances irritantes ni parfums agressifs."],
                    ['title' => 'Doux pour la peau', 'text' => "Idéal pour les peaux sensibles, les enfants et les bébés : votre linge est sain et agréable à porter."],
                    ['title' => 'Démarche responsable', 'text' => "Nous optimisons notre consommation d'eau et d'énergie pour réduire l'empreinte environnementale de chaque lavage."],
                ],
                'closing' => "Prendre soin de votre linge, c'est aussi prendre soin de la planète.",
            ],
        ];
    }

    public function show(string $slug)
    {
        $features = $this->features();

        abort_unless(isset($features[$slug]), 404);

        return view('features.show', [
            'feature' => $features[$slug],
            'slug' => $slug,
            'ctaUrl' => Auth::check() ? route('collecte') : route('register'),
            'ctaLabel' => Auth::check() ? 'Planifier ma collecte' : 'Créer un compte',
        ]);
    }
}
