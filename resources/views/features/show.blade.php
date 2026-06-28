@extends('layouts.app')

@section('title', $feature['title'] . ' - KLIN KLIN')

@section('content')
    @include('partials.navbar')

    <main class="feature-page">
        <header class="feature-hero">
            <div class="container text-center">
                <div class="feature-emoji">{{ $feature['emoji'] }}</div>
                <h1 class="hero-title">{{ $feature['title'] }}</h1>
                <p class="feature-lead">{{ $feature['lead'] }}</p>
            </div>
        </header>

        <section class="container feature-content">
            <div class="feature-points">
                @foreach ($feature['points'] as $point)
                    <article class="feature-point">
                        <h3>{{ $point['title'] }}</h3>
                        <p>{{ $point['text'] }}</p>
                    </article>
                @endforeach
            </div>

            <p class="feature-closing">{{ $feature['closing'] }}</p>

            <div class="feature-cta">
                <a href="{{ $ctaUrl }}" class="btn btn-purple">{{ $ctaLabel }}</a>
                <a href="{{ route('simulation') }}" class="btn btn-mint">Faire une simulation</a>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}#avantage" class="feature-back">← Retour aux avantages</a>
            </div>
        </section>
    </main>
@endsection
