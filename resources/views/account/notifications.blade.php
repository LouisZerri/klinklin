@extends('layouts.dashboard')

@section('title', 'Notifications | KLIN KLIN')
@section('account-title', 'Notifications')
@section('account-subtitle', 'Choisissez les communications que vous souhaitez recevoir.')

@section('account-content')
    <div class="account-layout">
        <div class="account-main">
            <div class="account-card">
        <form action="{{ route('account.notifications.update') }}" method="POST">
            @csrf
            @method('PUT')

            @php
                $options = [
                    'notification_profil_image' => ['Photo de profil', 'Rappels pour personnaliser votre photo de profil.'],
                    'notification_ressources_et_formations' => ['Ressources et formations', 'Conseils, guides et formations pour entretenir votre linge.'],
                    'notification_recommandation_de_produits' => ['Recommandations de produits', 'Suggestions de services et de produits adaptés à vos besoins.'],
                    'notification_conseils_et_bonne_pratique' => ['Conseils et bonnes pratiques', 'Astuces régulières pour prendre soin de vos vêtements.'],
                ];
            @endphp

            @foreach ($options as $field => [$label, $desc])
                <label class="account-toggle" for="{{ $field }}">
                    <div class="account-toggle-text">
                        <span class="account-toggle-label">{{ $label }}</span>
                        <span class="account-toggle-desc">{{ $desc }}</span>
                    </div>
                    <span class="account-switch">
                        <input type="checkbox" id="{{ $field }}" name="{{ $field }}" value="1"
                            @checked(old($field, $user->$field)) />
                        <span class="account-slider"></span>
                    </span>
                </label>
            @endforeach

            <div class="account-actions">
                <button type="submit" class="btn btn-purple">Enregistrer mes préférences</button>
            </div>
        </form>
            </div>
        </div>

        <aside class="account-aside">
            <div class="account-aside-icon"><i class="fa-solid fa-bell"></i></div>
            <h3>Restez informé, à votre rythme</h3>
            <p>Activez uniquement les communications qui vous intéressent. Vous pouvez modifier ces préférences à tout moment.</p>
            <ul>
                <li>Aucune notification n'est activée sans votre accord</li>
                <li>Les e-mails liés à vos commandes restent toujours envoyés</li>
            </ul>
        </aside>
    </div>
@endsection
