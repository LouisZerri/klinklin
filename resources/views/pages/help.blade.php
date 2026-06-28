@extends('layouts.app')

@section('title', "Centre d'aide - KLIN KLIN")

@section('content')
    @include('partials.navbar')

    <main class="help-page">
        <header class="help-hero">
            <div class="container text-center">
                <h1 class="hero-title">Centre d'aide</h1>
                <p class="help-lead">
                    Une question ? Retrouvez ici l'essentiel pour profiter
                    sereinement de votre service KLIN KLIN.
                </p>
            </div>
        </header>

        <section class="container help-content">
            <div class="help-topics">
                @foreach ($topics as $topic)
                    <article class="help-topic">
                        <div class="help-topic-emoji">{{ $topic['emoji'] }}</div>
                        <h3>{{ $topic['title'] }}</h3>
                        <p>{{ $topic['text'] }}</p>
                    </article>
                @endforeach
            </div>

            <h2 class="help-faq-title">Questions fréquentes</h2>
            <div class="help-faq">
                @foreach ($faqs as $faq)
                    <details class="help-faq-item">
                        <summary>{{ $faq['q'] }}</summary>
                        <p>{{ $faq['r'] }}</p>
                    </details>
                @endforeach
            </div>

            <div class="help-cta">
                <p>Vous n'avez pas trouvé votre réponse ?</p>
                <div class="feature-cta">
                    <a href="{{ route('register') }}" class="btn btn-purple">Créer un compte</a>
                    <a href="{{ route('simulation') }}" class="btn btn-mint">Faire une simulation</a>
                </div>
            </div>
        </section>
    </main>
@endsection
