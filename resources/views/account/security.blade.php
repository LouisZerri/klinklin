@extends('layouts.dashboard')

@section('title', 'Sécurité | KLIN KLIN')
@section('account-title', 'Sécurité')
@section('account-subtitle', 'Modifiez votre mot de passe et protégez votre compte.')

@section('account-content')
    <div class="account-layout">
        <div class="account-main">
            <div class="account-card">
                <h3 class="account-card-title">Changer de mot de passe</h3>

                <form action="{{ route('account.security.update') }}" method="POST" class="account-form">
                    @csrf
                    @method('PUT')

                    <div class="account-field mb-3">
                        <label for="current_password">Mot de passe actuel</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required />
                    </div>

                    <div class="account-grid">
                        <div class="account-field">
                            <label for="password">Nouveau mot de passe</label>
                            <input type="password" id="password" name="password" class="form-control" required />
                        </div>
                        <div class="account-field">
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required />
                        </div>
                    </div>

                    <div class="account-actions">
                        <button type="submit" class="btn btn-purple">Mettre à jour le mot de passe</button>
                    </div>
                </form>
            </div>
        </div>

        <aside class="account-aside">
            <div class="account-aside-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <h3>Un mot de passe solide</h3>
            <p>Pour protéger votre compte, votre mot de passe doit contenir :</p>
            <ul>
                <li>Au moins 8 caractères</li>
                <li>Une lettre majuscule et une minuscule</li>
                <li>Au moins un chiffre</li>
                <li>Un caractère spécial (@, !, %, #…)</li>
            </ul>
        </aside>
    </div>
@endsection
