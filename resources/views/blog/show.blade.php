@extends('layouts.app')

@section('title', $post['title'] . ' - KLIN KLIN')

@section('content')
    @include('partials.navbar')

    <main class="article-page">
        <div class="container">
            <a href="{{ route('home') }}#blog" class="feature-back d-inline-block mb-4">← Tous les articles</a>

            <header class="article-page-header">
                <span class="blog-tag">{{ $post['tag'] }}</span>
                <h1 class="hero-title">{{ $post['title'] }}</h1>
                <p class="article-page-lead">{{ $post['lead'] }}</p>
            </header>

            <div class="article-page-cover">
                <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" />
            </div>

            <article class="article-page-body">
                @foreach ($post['body'] as $section)
                    <h2>{{ $section['heading'] }}</h2>
                    <p>{{ $section['text'] }}</p>
                @endforeach
            </article>

            <div class="article-page-cta">
                <p>Envie d'un linge impeccable sans effort ?</p>
                <div class="feature-cta">
                    <a href="{{ route('simulation') }}" class="btn btn-purple">Faire une simulation</a>
                    <a href="{{ route('home') }}#blog" class="btn btn-mint">Voir d'autres conseils</a>
                </div>
            </div>
        </div>
    </main>
@endsection
