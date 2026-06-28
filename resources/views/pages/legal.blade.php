@extends('layouts.app')

@section('title', $title . ' - KLIN KLIN')

@section('content')
    @include('partials.navbar')

    <main class="legal-page">
        <div class="container">
            <a href="{{ route('home') }}" class="feature-back d-inline-block mb-4">← Retour à l'accueil</a>

            <header class="legal-header">
                <h1 class="hero-title">{{ $title }}</h1>
                <p class="legal-updated">Dernière mise à jour : {{ $updated }}</p>
                <p class="legal-lead">{{ $lead }}</p>
            </header>

            <article class="legal-body">
                @foreach ($sections as $section)
                    <h2>{{ $section['heading'] }}</h2>
                    <p>{{ $section['text'] }}</p>
                @endforeach
            </article>
        </div>
    </main>
@endsection
