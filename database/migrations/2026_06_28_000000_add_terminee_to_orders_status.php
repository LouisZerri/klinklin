<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ajoute le statut "Terminée" à l'enum des commandes.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('Prévu', 'Collecté', 'En nettoyage', 'Sortir pour livraison', 'Livré', 'En attente', 'Annulée', 'Terminée')");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('Prévu', 'Collecté', 'En nettoyage', 'Sortir pour livraison', 'Livré', 'En attente', 'Annulée')");
    }
};
