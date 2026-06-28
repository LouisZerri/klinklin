@extends('layouts.app')

@section('title', 'Dashboard | KLIN KLIN')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="dashboard-content flex-grow-1 ms-280 px-5 py-4">
        <div class="dashboard-header mb-5">
            <div class="image-wrapper">
                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="connection-image mt-5 mb-5" />
            </div>
            <h2>Bonjour {{ Auth::user()->firstname }} 👋</h2>
            <p>
                Bienvenue sur votre tableau de bord KLIN KLIN, où vous
                pouvez gérer vos services en toute simplicité : planifier
                une collecte, suivre vos commandes et ajuster vos
                informations ou votre abonnement.
            </p>
        </div>

        <div class="row gy-4 gx-4">
            <div class="col-md-6">
                <div class="card-dashboard bg-light-purple h-100">
                    <i class="fa-regular fa-calendar-alt icon-dashboard text-purple"></i>
                    <h3 class="fw-bold">Planifier une collecte</h3>
                    <p class="text-muted">
                        Dites-nous quand passer, on vient chercher votre
                        linge où que vous soyez !
                    </p>
                    <a href="{{ route('collecte')}}" class="btn btn-purple mt-auto w-auto">Nouvelle collecte →</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-dashboard bg-light-green h-100">
                    <i class="fa-solid fa-store icon-dashboard text-green"></i>
                    <h3 class="fw-bold">Mes commandes</h3>
                    <p class="text-muted">
                        Visualiser vos commandes en cours
                    </p>
                    <a href="{{ route('orders.index') }}" class="btn btn-green mt-auto">Voir mes commandes →</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-dashboard bg-light-yellow h-100">
                    <i class="fa-regular fa-file icon-dashboard text-yellow"></i>
                    <h3 class="fw-bold">Mon historique</h3>
                    <p class="text-muted">
                        Retrouvez toutes vos collectes passées en un clin
                        d’œil.
                    </p>
                    <a href="{{ route('orders.history') }}" class="btn btn-yellow mt-auto">Voir mes historiques →</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-dashboard bg-light-red h-100">
                    <i class="fa-solid fa-chart-line icon-dashboard text-danger"></i>
                    <h3 class="fw-bold">Mes activités</h3>
                    <p class="text-muted">
                        Factures, collectes, paiements… tout est ici pour
                        vous simplifier la vie.
                    </p>
                    <a href="#" class="btn btn-red mt-auto">Voir mes activités →</a>
                </div>
            </div>
        </div>
    </main>
    
    @include('layouts.mobilenavbar')

@endsection

