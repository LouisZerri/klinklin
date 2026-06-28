@extends('layouts.dashboard')

@section('title', $title . ' | KLIN KLIN')
@section('account-title', $title)
@section('account-subtitle', 'Dernière mise à jour : ' . $updated)

@section('account-content')
    <div class="account-layout">
        <div class="account-main">
            <div class="account-card">
                <p class="legal-lead">{{ $lead }}</p>

                <div class="legal-body">
                    @foreach ($sections as $section)
                        <h2>{{ $section['heading'] }}</h2>
                        <p>{{ $section['text'] }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <aside class="account-aside">
            <div class="account-aside-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <h3>Vos données, votre contrôle</h3>
            <p>Vous disposez d'un droit d'accès, de rectification et de suppression de vos données à tout moment.</p>
            <ul>
                <li>Données chiffrées et jamais revendues</li>
                <li>Paiements sécurisés via Stripe</li>
            </ul>
        </aside>
    </div>
@endsection
