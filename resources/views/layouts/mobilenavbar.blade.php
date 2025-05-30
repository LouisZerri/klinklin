<ul class="bottom-nav nav justify-content-around d-md-none fixed-bottom bg-purple text-white py-2 m-0">
    <li class="nav-item text-center">
        <a href="{{ route('dashboard') }}" class="nav-link text-white {{ Route::is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <div class="small">Accueil</div>
        </a>
    </li>
    <li class="nav-item text-center">
        <a href="#" class="nav-link text-white">
            <i class="fas fa-user"></i>
            <div class="small">Profil</div>
        </a>
    </li>
    <li class="nav-item text-center">
        <a href="#" class="nav-link text-white">
            <i class="fas fa-box"></i>
            <div class="small">Abonnement</div>
        </a>
    </li>
    <li class="nav-item text-center">
        <a href="#" class="nav-link text-white">
            <i class="fas fa-bell"></i>
            <div class="small">Notifications</div>
        </a>
    </li>

    <!-- Menu déroulant Plus -->
    <li class="nav-item dropdown">
        <a class="nav-link d-flex flex-column align-items-center text-white dropdown-toggle p-0" href="#"
            id="plusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-th-large mb-1"></i>
            <span>Plus</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="plusDropdown">
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-lock me-2"></i>Sécurité</a></li>
            <li>
                <a class="dropdown-item" href="#"><i class="fas fa-question-circle me-2"></i>Aide &
                    Support</a>
            </li>
            <li>
                <a class="dropdown-item" href="#"><i class="fas fa-shield-alt me-2"></i>Politique de
                    confidentialité</a>
            </li>
        </ul>
    </li>
</ul>
