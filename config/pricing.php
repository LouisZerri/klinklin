<?php

/*
|--------------------------------------------------------------------------
| Tarification
|--------------------------------------------------------------------------
| Frais appliqués à une commande, centralisés ici plutôt que codés en dur
| dans les contrôleurs.
*/

return [
    'expedition' => 10,        // frais de livraison (€)
    'tax' => 5,                // taxe estimée (€)
    'premium_discount' => 0.10, // remise sur le sous-total pour les abonnés Premium (10 %)
];
