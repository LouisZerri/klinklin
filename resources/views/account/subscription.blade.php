@extends('layouts.dashboard')

@section('title', 'Mon abonnement | KLIN KLIN')
@section('account-title', 'Mon abonnement')
@section('account-subtitle', 'Consultez votre formule et découvrez nos offres.')

@section('account-content')
    <div class="account-card mb-4">
        <h3 class="account-card-title">Formule actuelle</h3>
        @if ($current)
            <div class="account-current-plan">
                <div>
                    <div class="account-plan-name">{{ $current->name }}</div>
                    <span class="account-badge account-badge-{{ $current->status }}">{{ ucfirst($current->status) }}</span>
                </div>
                <div class="account-plan-price">
                    {{ $current->price > 0 ? number_format($current->price / 100, 2, ',', ' ') . ' € / mois' : 'Gratuit' }}
                </div>
            </div>
        @else
            <p class="text-muted mb-0">Vous n'avez pas encore d'abonnement actif.</p>
        @endif
    </div>

    <h3 class="account-section-heading">Nos formules</h3>
    <div class="account-plans">
        @forelse ($plans as $plan)
            <div class="account-plan-card {{ $current && $current->id === $plan->id ? 'is-current' : '' }}">
                <div class="account-plan-card-name">{{ $plan->name }}</div>
                <div class="account-plan-card-price">
                    {{ $plan->price > 0 ? number_format($plan->price / 100, 2, ',', ' ') . ' €' : '0 €' }}
                    <span>/ mois</span>
                </div>
                @if ($current && $current->id === $plan->id)
                    <button class="btn btn-purple w-100" disabled>Formule actuelle</button>
                @else
                    <button class="btn btn-mint w-100" disabled>Bientôt disponible</button>
                @endif
            </div>
        @empty
            <p class="text-muted">Aucune formule disponible pour le moment.</p>
        @endforelse
    </div>

    <p class="account-note mt-4">
        <i class="fas fa-circle-info me-1"></i>
        La gestion des abonnements (changement de formule, paiement récurrent) sera bientôt disponible.
    </p>
@endsection
