@extends('layouts.app')

@section('title', 'Choisissez vos articles')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="article-content flex-grow-1 ms-280 px-5 py-4">

        <progress-bar></progress-bar>

        <div class="article-header mb-5">
            <h2>Vous choisissez ce que nous lavons !</h2>
            <p class="mt-4">
                Ajoutez vos articles un par un et découvrez instantanément
                le tarif estimé pour votre commande.
            </p>
        </div>

        <article-selector :articles="{{ $articles->toJson() }}" post-articles-url="{{ route('post_articles') }}"
            cancel-url="{{ route('collecte') }}" csrf-token="{{ csrf_token() }}"></article-selector>


    </main>

    @include('layouts.mobilenavbar')

@endsection
