@extends('layouts.app')

@section('title', 'Récapitulatif de la commande')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="recap-content flex-grow-1 ms-280 px-5 py-4">

        <progress-bar></progress-bar>

        <div class="recap-header mb-5">
            <h2>Récapitulatifs de la commande</h2>
            <booking-selector
                :order="{{ json_encode([
                    'orderDate' => $order->order_date,
                    'timeslot' => $order->timeslot,
                    'address' => $order->address . ', ' . $order->zip_code . ' ' . $order->city,
                ]) }}"
                :slots="{{ json_encode(['08h00 - 10h00', '10h00 - 12h00', '12h00 - 14h00', '14h00 - 16h00', '16h00 - 18h00']) }}"
                update-url="{{ route('order.update-info') }}" csrf-token="{{ csrf_token() }}">
            </booking-selector>
        </div>

        <div class="recap-wrapper">
            <div class="article-summary">
                <div class="summary-title">
                    <span>Articles sélectionnés</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                @foreach ($items as $item)
                    <div class="summary-line">
                        <span>{{ $item->article_name }} - {{ $item->quantity }} pcs,
                            {{ number_format($item->estimated_weight, 1) }} kg</span>
                    </div>
                @endforeach

                <div class="summary-line total">
                    <span>Total estimé : {{ number_format($order->subtotal, 0, ',', ' ') }} €</span>
                </div>
            </div>

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
                        <span>{{ number_format($order->subtotal + $order->expedition + $order->tax, 0, ',', ' ') }}
                            €</span>
                    </div>
                </div>

                <div class="summary-actions">
                    <a href="{{ route('checkout.index') }}" class="btn btn-purple-dashboard">Passer au paiement</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-red">Annuler</a>
                </div>

                <div class="payment-info mt-3">Options de paiement disponibles</div>

                <div class="promo-section">
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
