@extends('layouts.dashboard')

@section('title', 'Historique des commandes | KLIN KLIN')
@section('account-title', 'Mon historique de commandes')
@section('account-subtitle', 'Consultez vos anciennes commandes, leurs détails et leur statut.')

@section('account-content')
    <order-history :orders="{{ json_encode($orders) }}"></order-history>
@endsection
