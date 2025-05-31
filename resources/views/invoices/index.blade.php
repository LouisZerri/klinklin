@extends('layouts.app')

@section('title', 'Mes factures')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="invoices-content flex-grow-1 ms-280 px-5 py-4">
        <div class="invoices-header mb-5">
            <h2>Mes factures</h2>
            <p class="mt-4">
                Consultez, téléchargez et suivez vos factures en un seul endroit
            </p>
        </div>
        <invoice :invoices='@json($invoices)' download-url="{{ route('invoices.download', ':id') }}"
            check-url="{{ route('invoices.check', ':id') }}"></invoice>

    </main>

    @include('layouts.mobilenavbar')

@endsection
