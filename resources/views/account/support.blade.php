@extends('layouts.dashboard')

@section('title', 'Aide & support | KLIN KLIN')
@section('account-title', 'Aide & support')
@section('account-subtitle', 'Besoin d\'un coup de main ? Nous sommes là pour vous.')

@section('account-content')
    @php
        $faqs = [
            ['Comment planifier une collecte ?', "Depuis votre tableau de bord, cliquez sur « Planifier une collecte », renseignez votre adresse puis choisissez vos articles et un créneau."],
            ['Quels sont les délais de livraison ?', "Votre linge propre et repassé vous est retourné sous 48 heures ouvrées après la collecte."],
            ['Puis-je annuler une collecte ?', "Oui, jusqu'à 2 heures avant le créneau choisi, directement depuis votre espace personnel."],
            ['Où trouver mes factures ?', "Toutes vos factures sont disponibles au téléchargement dans la rubrique « Factures »."],
            ['Comment modifier mes informations ?', "Rendez-vous dans la rubrique « Profil » pour mettre à jour vos coordonnées à tout moment."],
        ];
    @endphp

    <div class="account-grid account-grid-2 mb-4">
        <div class="account-card account-support-card">
            <i class="fas fa-envelope account-support-icon"></i>
            <h3 class="account-card-title">Nous écrire</h3>
            <p class="text-muted">Une question ? Écrivez-nous, nous répondons sous 24 h ouvrées.</p>
            <a href="mailto:support@klinklin.com" class="btn btn-purple">support@klinklin.com</a>
        </div>
        <div class="account-card account-support-card">
            <i class="fas fa-phone account-support-icon"></i>
            <h3 class="account-card-title">Par téléphone</h3>
            <p class="text-muted">Du lundi au samedi, de 9h à 19h.</p>
            <a href="tel:+33128964587" class="btn btn-mint">+33 1 28 96 45 87</a>
        </div>
    </div>

    <div class="account-card">
        <h3 class="account-card-title mb-3">Questions fréquentes</h3>
        <div class="help-faq">
            @foreach ($faqs as [$q, $r])
                <details class="help-faq-item">
                    <summary>{{ $q }}</summary>
                    <p>{{ $r }}</p>
                </details>
            @endforeach
        </div>
    </div>
@endsection
