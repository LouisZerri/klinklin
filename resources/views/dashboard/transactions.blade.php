@extends('layouts.app')

@section('title', 'Mes paiements')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="dashboard-content flex-grow-1 ms-280 px-5 py-4">
        <div class="dashboard-header mb-5">
            <h2>Mes paiements</h2>
            <p class="mt-4">
                Suivez vos transactions et méthodes de paiement.
            </p>
        </div>
        <payment-history :orders='@json($orders)' download-url="{{ route('invoices.download', ':id') }}"
            check-url="{{ route('invoices.check', ':id') }}" order-id="{{ route('orders.show', ':id')}}"></payment-history>
    </main>

    @include('layouts.mobilenavbar')

@endsection
