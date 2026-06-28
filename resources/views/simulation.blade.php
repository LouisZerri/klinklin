@extends('layouts.app')

@section('title', 'Simulation de tarif - KLIN KLIN')

@section('content')
    @include('partials.navbar')

    <main class="simulation-page container py-5">
        <header class="simulation-header text-center mb-5">
            <h1 class="hero-title">Simulez le tarif de votre collecte</h1>
            <p class="hero-subtitle mt-3">
                Choisissez vos articles et découvrez instantanément une estimation,
                sans engagement.
            </p>
        </header>

        @if ($articles->isEmpty())
            <div class="alert alert-info text-center">
                Aucun article n'est disponible pour le moment. Revenez bientôt !
            </div>
        @else
            <simulation-selector
                :articles="{{ $articles->toJson() }}"
                cta-url="{{ $ctaUrl }}"
                cta-label="{{ $ctaLabel }}"
                :delivery-fee="{{ $deliveryFee }}"
                :tax-fee="{{ $taxFee }}">
            </simulation-selector>
        @endif
    </main>
@endsection
