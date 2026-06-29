@extends('layouts.app')

@use('App\Enums\OrderStatus')

@section('title', 'Mes commandes')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="order-details-content flex-grow-1 ms-280 px-5 py-4">
        <div class="order-details-header mb-4">
            <h2>Détails de la commande {{ $order->order_number }}</h2>
        </div>

        <div class="order-details-section">
            <h3 class="section-title">Date & créneau horaire</h3>
            <div class="section-content">{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }},
                {{ $order->timeslot }}</div>
        </div>

        <div class="order-details-section mt-4">
            <h3 class="section-title">Adresse de Livraison</h3>
            <div class="section-content">{{ $order->address }}, {{ $order->city }} {{ $order->zip_code }}</div>
        </div>

        <div class="order-details-section mt-4">
            <h2 class="section-title">
                Articles sélectionnés
                <span class="dropdown-arrow">⌄</span>
            </h2>
            <div class="items-list">
                @if ($order->orderItems->isEmpty())
                    <p>Aucun article sélectionné</p>
                @else
                    @foreach ($order->orderItems as $item)
                        <div class="item">{{ $item->article->name }} - {{ $item->quantity }} pcs,
                            {{ number_format($item->estimated_weight, 1) }} kg</div>
                    @endforeach

                    @if ($order->subtotal == 0)
                        <div class="item">Total : 0 €</div>
                    @else
                        <div class="item">Total : {{ number_format($order->total, 0, ',', ' ') }} €</div>
                    @endif
                @endif
            </div>
        </div>

        <div class="order-details-section mt-4">
            <h3 class="section-title">Méthode de paiement</h3>
            <div class="section-content">Carte de crédit</div>
        </div>

        @php
            $steps = OrderStatus::trackingSteps();
            $currentStep = $order->status->trackingIndex();
            $progress = $currentStep !== null ? ($currentStep / (count($steps) - 1)) * 100 : 0;
        @endphp

        <div class="order-details-section mt-4">
            <h3 class="section-title">Suivi de commande</h3>
        </div>

        @if ($order->status->isCancelled())
            <div class="order-cancelled-banner">
                <i class="fa-solid fa-circle-xmark"></i>
                <div>
                    <strong>Commande annulée</strong>
                    <span>Cette commande a été annulée et ne sera pas traitée.</span>
                </div>
            </div>
        @else
            <div class="progress-tracker">
                <div class="progress-tracker-container">
                    <div class="progress-line">
                        <div class="progress-line-active"
                            style="width: {{ $progress }}%; --progress-height: {{ $progress }}%">
                        </div>
                    </div>

                    @foreach ($steps as $index => $step)
                        @php
                            $circleClass = '';
                            $labelClass = '';

                            if ($currentStep !== null && $index < $currentStep) {
                                $circleClass = 'completed';
                                $labelClass = 'completed';
                            } elseif ($currentStep !== null && $index === $currentStep) {
                                $circleClass = 'active';
                                $labelClass = 'active';
                            }
                        @endphp

                        <div class="step-tracker">
                            <div class="step-tracker-circle {{ $circleClass }}"></div>
                            <div class="step-tracker-label {{ $labelClass }}">
                                {{ $step->label() }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="buttons-container">
            @if ($order->status->isCancellable())
                <form action="{{ route('order.cancel', $order->id) }}" method="POST"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                    @csrf
                    <button type="submit" class="btn btn-purple-dashboard">Annuler ma commande</button>
                </form>
            @else
                <a href={{ route('collecte') }} class="btn btn-purple-dashboard">Reprogrammer une collecte</a>
            @endif
            @if ($order->invoice && $order->invoice->id)
                <a href="/factures/{{ $order->invoice->id }}/download" class="btn btn-purple-dashboard">Télécharger la
                    facture</a>
            @else
                <button class="btn btn-purple-dashboard-disabled">Facture non disponible</button>
            @endif
        </div>

    </main>

    @include('layouts.mobilenavbar')

@endsection
