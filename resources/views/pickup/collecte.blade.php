@extends('layouts.app')

@section('title', 'Planifier une collecte')

@section('content')

    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="pickup-content flex-grow-1 ms-280 px-5 py-4">
        
        <progress-bar></progress-bar>

        <div class="pickup-header mb-5">
            <h2>Planifier une collecte 📅</h2>
            <p class="mt-4">
                Choisissez la date, le créneau horaire et l’adresse pour
                planifier votre prochaine collecte de linge.
            </p>
        </div>
        <form method="POST" action="{{ route('post_address')}}">
            @csrf
            <div class="form-grid">
                <div class="field">
                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse" name="address" placeholder="95 Rue Pointe Noire, Congo" required />
                </div>
                <div class="field">
                    <label for="complement">Complément d’adresse</label>
                    <input type="text" id="complement" name="complement" placeholder="Appartement, suite, etc." />
                </div>
    
                <div class="field">
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" name="city" placeholder="Brazzaville" required />
                </div>
                <div class="field">
                    <label for="postal">Code postal</label>
                    <input type="text" id="postal" name="zip_code" placeholder="7500" required />
                </div>
    
                <div class="field">
                    <label for="date">Date</label>
                    <input type="date" name="order_date" id="date" required />
                </div>
                <div class="field">
                    <label for="horaire">Créneau horaire</label>
                    <select id="horaire" name="timeslot">
                        <option value="08h00 - 10h00">08h - 10h</option>
                        <option value="10h00 - 12h00">10h - 12h</option>
                        <option value="12h00 - 14h00">12h - 14h</option>
                        <option value="14h00 - 16h00">14h - 16h</option>
                        <option value="16h00 - 18h00">16h - 18h</option>
                    </select>
                </div>
            </div>
    
            <div class="form-buttons">
                <button type="submit" class="btn btn-purple-dashboard">
                    Continuer vers les articles
                </button>
                <a type="button" href="{{ route('dashboard')}}" class="btn btn-red">
                    Retour
                </a>
            </div>
        </form>
    </main>

    @include('layouts.mobilenavbar')
@endsection
