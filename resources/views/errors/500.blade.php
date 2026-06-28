@extends('layouts.app')

@section('title', 'Erreur serveur - KLIN KLIN')

@section('content')
    @include('errors._card', [
        'code' => '500',
        'title' => 'Oups ! Une panne dans la machine...',
        'message' => "Notre tambour s'est emmêlé un instant. Nos équipes s'en occupent. Réessayez dans quelques instants, KLIN KLIN revient tout propre !",
    ])
@endsection
