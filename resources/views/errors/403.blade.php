@extends('layouts.app')

@section('title', 'Accès refusé - KLIN KLIN')

@section('content')
    @include('errors._card', [
        'code' => '403',
        'title' => 'Accès refusé',
        'message' => "Cette zone est réservée. Comme un vêtement délicat, certaines pages demandent les bonnes autorisations. Vérifiez que vous êtes bien connecté au bon compte.",
    ])
@endsection
