@extends('layouts.app')

@section('title', 'Mes activités')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="dashboard-content flex-grow-1 ms-280 px-5 py-4">
        <div class="dashboard-header mb-5">
            <h2>Mes Activités</h2>
            <p class="mt-4">
                Factures, collectes, paiements... tout est ici pour vous simplifier la vie.
            </p>
        </div>
        <div class="card-activities-container">
            <!-- Carte 1 -->
            <div class="card-activity">
                <h3><i class="fa-solid fa-truck-pickup"></i>Collectes en cours</h3>
                <p>{{ $ordersInProgress }}</p>
            </div>

            <!-- Carte 2 -->
            <div class="card-activity">
                <h3><i class="fa-solid fa-credit-card"></i>Paiements récents</h3>
                <p>{{ $latestPayments }} €</p>
            </div>

            <!-- Carte 3 -->
            <div class="card-activity">
                <h3><i class="fa-regular fa-file"></i>Factures disponibles</h3>
                <p>{{ $invoices }}</p>
            </div>
        </div>
        <div class="card-grid-activity">
            <div class="card-box">
                <h4><i class="fa-regular fa-file"></i> Mes factures</h4>
                <p>Consultez, téléchargez et suivez vos factures.</p>
                <div class="activity-buttons">
                    <a href="{{ route('invoices.index') }}" class="btn activity-button">Voir mes factures</a>
                    <a href="{{ route('invoices.download_all') }}" class="btn activity-button-transparent">Télécharger</a>
                </div>
            </div>

            <div class="card-box">
                <h4><i class="fa-solid fa-truck"></i> Mes collectes</h4>
                <p>Gérez vos collectes passées, en cours et futures.</p>
                <div class="activity-buttons">
                    <a href="{{ route('orders.index')}}" class="btn activity-button">Voir mes collectes</a>
                    <a href="{{ route('collecte') }}" class="btn activity-button-transparent">Replanifier</a>
                </div>
            </div>

            <div class="card-box">
                <h4><i class="fa-solid fa-credit-card"></i> Mes paiements</h4>
                <p>Suivez vos transactions et méthodes de paiement.</p>
                <div class="activity-buttons">
                    <a href="{{ route('dashboard.transactions')}}" class="btn activity-button">Gérer mes paiements</a>
                </div>
            </div>

            <div class="card-box">
                <h4><i class="fa-solid fa-rotate"></i> Activités récurrentes</h4>
                <p>Configurez vos préférences pour un service automatisé.</p>
                <div class="activity-buttons">
                    <a href="{{ route('account.notifications')}}" class="btn activity-button">Gérer mes activités</a>
                </div>
            </div>
        </div>
    </main>
    
    @include('layouts.mobilenavbar')

@endsection
