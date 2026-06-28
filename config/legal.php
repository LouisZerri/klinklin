<?php

/*
|--------------------------------------------------------------------------
| Contenu légal
|--------------------------------------------------------------------------
| Source unique des pages "Politique de confidentialité" et "Termes et
| conditions", utilisée à la fois par les pages publiques (PageController)
| et par l'espace personnel (AccountController).
*/

return [

    'privacy' => [
        'title' => 'Politique de confidentialité',
        'updated' => 'juin 2026',
        'lead' => "La présente politique décrit la manière dont KLIN KLIN collecte, utilise et protège vos données personnelles lorsque vous utilisez notre service.",
        'sections' => [
            ['heading' => '1. Données collectées', 'text' => "Nous collectons les informations que vous nous fournissez lors de la création de votre compte (nom, prénom, adresse e-mail, numéro de téléphone), les adresses de collecte et de livraison, ainsi que les données nécessaires au traitement de vos commandes et paiements."],
            ['heading' => '2. Utilisation des données', 'text' => "Vos données sont utilisées pour gérer votre compte, traiter vos commandes, organiser les collectes et livraisons, émettre vos factures et vous tenir informé de l'avancement de votre service. Elles ne sont en aucun cas revendues à des tiers."],
            ['heading' => '3. Paiements', 'text' => "Les transactions sont traitées par notre prestataire de paiement Stripe. Vos coordonnées bancaires sont transmises de manière chiffrée et ne sont jamais conservées sur nos serveurs."],
            ['heading' => '4. Conservation des données', 'text' => "Vos données sont conservées pendant la durée nécessaire à la fourniture du service et au respect de nos obligations légales et comptables, puis supprimées ou anonymisées."],
            ['heading' => '5. Vos droits', 'text' => "Conformément au RGPD, vous disposez d'un droit d'accès, de rectification, d'effacement et de portabilité de vos données, ainsi que d'un droit d'opposition. Vous pouvez exercer ces droits en nous contactant."],
            ['heading' => '6. Cookies', 'text' => "Notre site utilise des cookies strictement nécessaires à son fonctionnement (session, sécurité). Aucun cookie publicitaire n'est déposé sans votre consentement."],
            ['heading' => '7. Contact', 'text' => "Pour toute question relative à vos données personnelles, vous pouvez nous écrire à l'adresse de contact indiquée sur le site."],
        ],
    ],

    'terms' => [
        'title' => 'Termes et conditions',
        'updated' => 'juin 2026',
        'lead' => "Les présentes conditions générales régissent l'utilisation du service KLIN KLIN. En créant un compte et en passant commande, vous les acceptez sans réserve.",
        'sections' => [
            ['heading' => '1. Objet', 'text' => "KLIN KLIN propose un service de collecte, de lavage et de livraison de linge à domicile ou sur le lieu de travail de l'utilisateur."],
            ['heading' => '2. Compte utilisateur', 'text' => "L'accès au service nécessite la création d'un compte avec des informations exactes et à jour. Vous êtes responsable de la confidentialité de vos identifiants et de toute activité réalisée depuis votre compte."],
            ['heading' => '3. Commandes', 'text' => "Une commande est confirmée après validation du récapitulatif et du paiement. Le tarif affiché avant paiement inclut le sous-total des articles, les frais de livraison et les taxes applicables."],
            ['heading' => '4. Collecte et livraison', 'text' => "Vous vous engagez à être disponible sur le créneau choisi. Une collecte peut être annulée jusqu'à 2 heures avant le créneau. KLIN KLIN ne saurait être tenu responsable d'un retard dû à un cas de force majeure."],
            ['heading' => '5. Prix et paiement', 'text' => "Les prix sont indiqués en euros, toutes taxes comprises. Le paiement s'effectue en ligne par carte bancaire via notre prestataire sécurisé. Une facture est émise pour chaque commande."],
            ['heading' => '6. Responsabilité', 'text' => "Nous apportons le plus grand soin à vos textiles. Toute réclamation relative à l'état d'un article doit nous être signalée dans les meilleurs délais après la livraison. Les estimations de tarif fournies par le simulateur sont indicatives."],
            ['heading' => '7. Résiliation', 'text' => "Vous pouvez résilier votre compte ou votre abonnement à tout moment depuis votre espace personnel, sans frais cachés."],
            ['heading' => '8. Droit applicable', 'text' => "Les présentes conditions sont soumises au droit applicable du pays d'exploitation du service. Tout litige relève de la compétence des tribunaux concernés."],
        ],
    ],

];
