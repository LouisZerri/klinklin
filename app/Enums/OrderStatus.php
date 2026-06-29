<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'En attente';
    case Scheduled = 'Prévu';
    case Collected = 'Collecté';
    case Cleaning = 'En nettoyage';
    case OutForDelivery = 'Sortir pour livraison';
    case Delivered = 'Livré';
    case Cancelled = 'Annulée';
    case Completed = 'Terminée';

    /**
     * Libellé affiché (déjà en français).
     */
    public function label(): string
    {
        return $this->value;
    }

    /**
     * Étapes ordonnées du suivi de commande.
     *
     * @return array<int, self>
     */
    public static function trackingSteps(): array
    {
        return [
            self::Scheduled,
            self::Collected,
            self::Cleaning,
            self::OutForDelivery,
            self::Delivered,
        ];
    }

    /**
     * Index de l'étape courante dans le suivi (null si hors suivi).
     */
    public function trackingIndex(): ?int
    {
        // Une commande terminée est considérée comme entièrement livrée.
        if ($this === self::Completed) {
            return count(self::trackingSteps()) - 1;
        }

        $index = array_search($this, self::trackingSteps(), true);

        return $index === false ? null : $index;
    }

    public function isCancelled(): bool
    {
        return $this === self::Cancelled;
    }

    /**
     * Une commande payée et planifiée peut être annulée / remboursée.
     */
    public function isCancellable(): bool
    {
        return $this === self::Scheduled;
    }
}
