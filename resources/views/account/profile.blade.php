@extends('layouts.dashboard')

@section('title', 'Profil | KLIN KLIN')
@section('account-title', 'Mon profil')
@section('account-subtitle', 'Gérez vos informations personnelles.')

@section('account-content')
    <div class="account-layout">
        <div class="account-main">
            <div class="account-card">
                <div class="account-profile-head">
                    <img src="{{ $user->avatar }}" alt="Avatar" class="account-avatar" />
                    <div>
                        <div class="account-profile-name">{{ $user->firstname }} {{ $user->lastname }}</div>
                        <div class="account-profile-email">{{ $user->email }}</div>
                    </div>
                </div>

                <form action="{{ route('account.profile.update') }}" method="POST" class="account-form">
                    @csrf
                    @method('PUT')

                    <div class="account-grid">
                        <div class="account-field">
                            <label for="firstname">Prénom</label>
                            <input type="text" id="firstname" name="firstname" class="form-control"
                                value="{{ old('firstname', $user->firstname) }}" required />
                        </div>
                        <div class="account-field">
                            <label for="lastname">Nom</label>
                            <input type="text" id="lastname" name="lastname" class="form-control"
                                value="{{ old('lastname', $user->lastname) }}" required />
                        </div>
                        <div class="account-field">
                            <label for="email">Adresse e-mail</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required />
                        </div>
                        <div class="account-field">
                            <label for="phone">Téléphone</label>
                            <input type="text" id="phone" name="phone" class="form-control"
                                value="{{ old('phone', $user->phone) }}" required />
                        </div>
                        <div class="account-field">
                            <label for="language">Langue</label>
                            <select id="language" name="language" class="form-control">
                                @foreach (['français', 'english'] as $lang)
                                    <option value="{{ $lang }}" @selected(old('language', $user->language) === $lang)>
                                        {{ ucfirst($lang) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="account-actions">
                        <button type="submit" class="btn btn-purple">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>

        <aside class="account-aside">
            <div class="account-aside-icon"><i class="fa-solid fa-user-shield"></i></div>
            <h3>Vos informations</h3>
            <p>Ces données nous permettent de planifier vos collectes et de vous tenir informé du suivi de vos commandes.</p>
            <ul>
                <li>Gardez votre téléphone à jour pour la coordination des collectes</li>
                <li>Votre e-mail sert à la connexion et à l'envoi des factures</li>
                <li>Vos données ne sont jamais revendues à des tiers</li>
            </ul>
        </aside>
    </div>
@endsection
