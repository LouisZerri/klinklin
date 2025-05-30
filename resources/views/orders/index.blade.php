@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="orders-content flex-grow-1 ms-280 px-5 py-4">
        <div class="orders-header mb-5">
            <h2>Mes commandes</h2>
            <p class="mt-4">
                Gérez et suivez l'état de toutes vos commandes en un seul endroit.
            </p>
        </div>
        <order :orders="{{ json_encode($orders) }}"></order>
    </main>

    @include('layouts.mobilenavbar')

@endsection
