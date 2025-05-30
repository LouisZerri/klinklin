@extends('layouts.app')

@section('title', 'Paiement de la commande')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="payment-content flex-grow-1 ms-280 px-5 py-4">

        <progress-bar></progress-bar>

        <div class="recap-header mb-5">
            <h2>Effectuer le paiement de la commande</h2>
        </div>
        <div class="recap-wrapper">
            <stripe-checkout :total="{{ json_encode($total) }}"></stripe-checkout>
            <div class="recap-summary-box">
                <div class="summary-header mb-3">Récapitulatif</div>

                <div class="summary-details">
                    <div class="summary-row">
                        <span>Sous-total</span>
                        <span>{{ number_format($order->subtotal, 0, ',', ' ') }} €</span>
                    </div>
                    <div class="summary-row">
                        <span>Expédition</span>
                        <span>{{ number_format($order->expedition, 0, ',', ' ') }} €</span>
                    </div>
                    <div class="summary-row">
                        <span>Taxe estimée</span>
                        <span>{{ number_format($order->tax, 0, ',', ' ') }} €</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>{{ $total }} €</span>
                    </div>
                </div>
                <div class="promo-section mt-5">
                    <div class="promo-input">
                        <label>Code promo</label>
                        <input type="text" placeholder="Entrer le code" />
                    </div>
                    <button class="btn btn-purple-dashboard">Appliquer</button>
                </div>
            </div>
            
        </div>
    </main>

    @include('layouts.mobilenavbar')

@endsection
