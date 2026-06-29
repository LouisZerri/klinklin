@extends('layouts.dashboard')

@section('title', 'Mon abonnement | KLIN KLIN')
@section('account-title', 'Mon abonnement')
@section('account-subtitle', 'Profitez de plus d\'avantages avec KLIN KLIN Premium.')

@section('account-content')
    @php
        $freeBenefits = [
            'Collecte et livraison à domicile',
            'Suivi de commande en temps réel',
            'Paiement sécurisé à la commande',
            'Factures téléchargeables',
        ];
        $isPremium = $user->hasActiveSubscription();
    @endphp

    @if ($isPremium)
        {{-- Abonné Premium --}}
        <div class="account-card sub-current">
            <div class="sub-current-head">
                <div>
                    <span class="sub-badge sub-badge-premium"><i class="fa-solid fa-crown"></i> Premium</span>
                    <h3 class="account-card-title mt-2 mb-1">Vous êtes abonné Premium</h3>
                    <p class="text-muted mb-0">{{ $premium->priceLabel() }} · renouvellement automatique</p>
                </div>
            </div>

            <ul class="sub-benefits mt-3">
                @foreach ($premium->benefits as $benefit)
                    <li><i class="fa-solid fa-check"></i> {{ $benefit }}</li>
                @endforeach
            </ul>

            <form action="{{ route('account.subscription.cancel') }}" method="POST" class="mt-4"
                onsubmit="return confirm('Résilier votre abonnement Premium ?')">
                @csrf
                <button type="submit" class="btn btn-red">Résilier mon abonnement</button>
            </form>
        </div>
    @else
        {{-- Offre gratuite + upsell Premium --}}
        <div class="sub-plans">
            <div class="account-card sub-plan">
                <div class="sub-plan-head">
                    <h3 class="sub-plan-name">Offre gratuite</h3>
                    <div class="sub-plan-price">0 € <span>/ mois</span></div>
                </div>
                <p class="sub-plan-tag">Votre formule actuelle</p>
                <ul class="sub-benefits">
                    @foreach ($freeBenefits as $benefit)
                        <li><i class="fa-solid fa-check"></i> {{ $benefit }}</li>
                    @endforeach
                </ul>
                <button class="btn btn-mint w-100 mt-3" disabled>Formule actuelle</button>
            </div>

            <div class="account-card sub-plan sub-plan-featured">
                <div class="sub-plan-head">
                    <h3 class="sub-plan-name"><i class="fa-solid fa-crown"></i> Premium</h3>
                    <div class="sub-plan-price">{{ number_format($premium->price / 100, 2, ',', ' ') }} € <span>/ mois</span></div>
                </div>
                <p class="sub-plan-tag">Tous les avantages gratuits, plus :</p>
                <ul class="sub-benefits">
                    @foreach ($premium->benefits as $benefit)
                        <li><i class="fa-solid fa-check"></i> {{ $benefit }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('account.subscription.subscribe') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-purple w-100">Passer au Premium</button>
                </form>
            </div>
        </div>

        <p class="account-note mt-4">
            <i class="fas fa-circle-info me-1"></i>
            Paiement sécurisé via Stripe (mode test). Résiliable à tout moment.
        </p>
    @endif
@endsection
