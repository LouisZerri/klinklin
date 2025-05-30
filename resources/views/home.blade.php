@extends('layouts.app')
@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-white navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="/">
                <svg width="85" height="113" viewBox="0 0 85 113" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_7_511)">
                        <path d="M73.2632 34.0097V33.6897L76.6101 33.4155L73.2632 34.0097Z" fill="#C10606" />
                        <path
                            d="M0.504333 32.2269L19.76 21.9875L40.0243 18.2391H41.6289V9.82807L44.609 9.46238L47.1305 5.39401L43.2794 2.74272L39.0615 7.17678L36.2648 6.26254L43.2336 0L48.3684 5.48544L44.9299 13.9879L47.1305 18.6505L66.7071 20.1133L85 33.7354L77.0685 35.0154L64.7357 23.8159L40.6203 23.176L25.2158 27.4729L15.2212 33.964L0.504333 32.2269Z"
                            fill="#684289" />
                        <path
                            d="M3.39268 29.3928L21.548 19.0162L41.6289 15.3135L43.3711 15.2678V8.68527L46.2136 8.45671L48.5518 4.84547L44.5631 2.55987L40.8495 6.62824L37.9612 5.714L44.8841 0L49.9731 4.89118L46.6721 11.0166L48.9186 15.6792L67.4407 18.9248L85 30.2613L78.7649 31.8155L66.4779 20.8904L42.3625 20.2047L26.9579 24.5016L16.9633 31.0384L3.39268 29.3928Z"
                            fill="#461871" />
                        <path
                            d="M80.3236 86.807L74.3177 92.4753L68.8161 93.1152L67.8075 89.6869L66.7071 93.2067H62.0766L62.3975 109.389L53.7783 111.309L54.3285 93.7552L50.8441 93.6638V97.8236L46.0302 106.189L41.5831 100.338L41.904 91.4239L36.6316 91.9724L36.6775 110.714L28.5626 113L28.8377 93.2981L19.8058 94.9894L18.7055 93.2524L18.2929 95.3094L1.52588e-05 98.0979L2.84252 63.4939H0.596024V39.7694L8.34414 33.7354L16.5049 35.3353L21.9606 32.6383L39.4283 34.2382L39.6575 40.4093L44.9757 35.9753L67.7616 34.1468L69.4579 37.1181L69.137 37.3924L69.1829 37.4838L73.2632 33.6897V44.752L80.0027 56.7742L75.418 62.6711L80.3236 86.807Z"
                            fill="#684289" />
                        <path
                            d="M22.3274 44.9806L29.5254 57.3685L21.2729 58.8313L16.0464 51.4259L15.6796 59.2884L8.34413 59.3798L8.57337 32.4098L16.9175 33.0954L16.5507 41.0493L21.9606 32.6383L30.534 33.4154L22.3274 44.9806Z"
                            fill="#BA9D9D" />
                        <path
                            d="M46.0302 48.4547L45.3884 56.2257L36.815 56.8657H36.7692L30.534 57.4142L31.13 32.9126H40.2994L38.9698 48.4547H46.0302Z"
                            fill="#BA9D9D" />
                        <path d="M54.3744 57.6885L46.9013 58.0085V34.1926L56.4375 33.7354L54.3744 57.6885Z"
                            fill="#BA9D9D" />
                        <path
                            d="M81.6532 33.2783L80.3236 57.0485L71.0626 58.0085L66.2486 45.6205L65.6068 58.0999H57.5378L58.1338 33.0955L66.5237 32.9126L66.9822 32.6841L73.034 43.7006L73.2632 34.0097L73.3091 33.5069L81.6532 33.2783Z"
                            fill="#BA9D9D" />
                        <path
                            d="M27.5539 17.9191L30.5798 17.3705L31.8635 18.1019L34.706 22.0332L35.027 36.3867L30.534 35.9753V22.3532L30.0755 20.7532L27.5539 17.9191Z"
                            fill="#684289" />
                        <path
                            d="M53.0447 16.4106L55.6122 16.8677L57.2168 17.142L60.1968 20.7533L60.6095 35.6554L55.5663 35.9753L55.9331 20.8904L55.1995 19.0162L53.0447 16.4106Z"
                            fill="#684289" />
                        <path
                            d="M41.7664 15.2678H43.3711L46.3053 17.7363L48.9186 15.6792L50.6607 15.9992L48.0933 20.0676L48.6893 35.9296L44.5173 36.3868L45.4342 20.3419L41.7664 15.2678Z"
                            fill="#684289" />
                        <path
                            d="M22.3274 74.7848L29.5254 87.127L21.2729 88.5898L16.0464 81.2302L15.6796 89.0469L8.34413 89.1841L8.57337 62.1683L16.9175 62.854L16.5507 70.8535L21.9606 62.4425L30.534 63.1739L22.3274 74.7848Z"
                            fill="#8DFFC8" />
                        <path
                            d="M46.0302 78.2132L45.3884 86.0299L36.815 86.6242H36.7692L30.534 87.1727L31.13 62.6711H40.2994L38.9698 78.2132H46.0302Z"
                            fill="#8DFFC8" />
                        <path d="M54.3744 87.447L46.9013 87.767V63.951L56.4375 63.4939L54.3744 87.447Z" fill="#8DFFC8" />
                        <path
                            d="M81.6532 63.0368L80.3236 86.807L71.0626 87.767L66.2486 75.379L65.6068 87.8584H57.5378L58.1338 62.7168H66.5237H67.028L73.034 73.4591L73.3091 63.2654L81.6532 63.0368Z"
                            fill="#8DFFC8" />
                        <path
                            d="M22.3274 44.9806L29.5254 57.3685L21.2729 58.8313L16.0464 51.4259L15.6796 59.2884L8.34413 59.3798L8.57337 32.4098L16.9175 33.0954L16.5507 41.0493L21.9606 32.6383L30.534 33.4154L22.3274 44.9806Z"
                            fill="#8DFFC8" />
                        <path
                            d="M46.0302 48.4547L45.3884 56.2257L36.815 56.8657H36.7692L30.534 57.4142L31.13 32.9126H40.2994L38.9698 48.4547H46.0302Z"
                            fill="#8DFFC8" />
                        <path d="M54.3744 57.6885L46.9013 58.0085V34.1926L56.4375 33.7354L54.3744 57.6885Z"
                            fill="#8DFFC8" />
                        <path
                            d="M81.6532 33.2783L80.3236 57.0485L71.0626 58.0085L66.2486 45.6205L65.6068 58.0999H57.5378L58.1338 32.9126H66.5237H67.028L73.034 43.7006L73.3091 33.5069L81.6532 33.2783Z"
                            fill="#8DFFC8" />
                    </g>
                    <defs>
                        <clipPath id="clip0_7_511">
                            <rect width="85" height="113" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-4 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#ccm">Comment ça marche ?</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#avantage">Nos Avantages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#temoignages">Témoignages</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown">Ressources</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#blog">Blog</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#faq">FAQ</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Centre d'aide</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div
                    class="d-flex gap-3 align-items-center justify-content-center justify-content-lg-end w-100 mt-3 mt-lg-0">
                    <a href="{{ route('login') }}" class="nav-link connexion-link">Connexion</a>
                    <a href="{{ route('register')}}" class="btn btn-purple">Créez un compte</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section position-relative">
        <div class="container position-relative">
            <div class="row">
                <div class="col-lg-6 position-relative">
                    <h1 class="hero-title">
                        Votre <span class="highlight">linge</span><br />
                        <span class="highlight">propre</span>, sans<br />
                        quitter<br />
                        la <span class="highlight">maison</span>.
                    </h1>
                    <p class="hero-subtitle">
                        Planifiez la collecte, on s’occupe du reste.<br />
                        Livraison en 48h, soignée et sécurisée.
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 hero-buttons">
                        <a href="#" class="btn btn-purple">Planifier une collecte</a>
                        <a href="#" class="btn btn-mint">Faire une simulation</a>
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0 position-relative">
                    <div class="hero-image-box">
                        <div class="hero-banner-top"></div>
                        <img src="./images/main.jpg" alt="Illustration KLIN" class="img-fluid rounded-image" />
                        <img src="./images/Group.png" alt="Special Edition" class="badge-special" />
                    </div>
                </div>
            </div>
            <svg class="icon-deco-violet" width="108" height="107" viewBox="0 0 108 107" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_42_37)">
                    <path
                        d="M31.1221 20.0801L60.3208 13.6899C60.3208 13.6899 59.4852 21.5221 47.319 24.1847C35.1529 26.8473 31.1221 20.0801 31.1221 20.0801Z"
                        fill="#553788" />
                    <path
                        d="M83.6413 43.8316L91.3464 27.298C80.5485 24.5616 60.3208 13.6899 60.3208 13.6899C60.3208 13.6899 57.5844 24.4878 47.8515 26.6179C38.1186 28.748 31.1221 20.0801 31.1221 20.0801C31.1221 20.0801 17.2846 38.4071 8.61677 45.4036L22.5192 57.2109L32.6459 50.3438C32.6459 50.3438 41.7745 89.1423 35.464 98.1727C35.464 98.1727 48.1627 97.9433 62.762 94.7482C77.3614 91.5531 88.995 86.4573 88.995 86.4573C79.4895 80.8883 71.5775 41.8236 71.5775 41.8236L83.6413 43.8316Z"
                        fill="#AA8DD8" />
                    <path
                        d="M23.978 57.3404C23.6131 57.4204 23.2349 57.4173 22.8714 57.3313C22.5079 57.2454 22.1684 57.0787 21.878 56.8438L9.48247 46.8078C9.21767 46.6057 8.9961 46.3525 8.83087 46.0633C8.66563 45.7741 8.56009 45.4546 8.52048 45.1239C8.48087 44.7932 8.508 44.4578 8.60027 44.1378C8.69254 43.8177 8.84806 43.5194 9.05765 43.2605C9.26723 43.0016 9.52662 42.7874 9.82046 42.6305C10.1143 42.4736 10.4366 42.3772 10.7684 42.3471C11.1001 42.317 11.4345 42.3537 11.7518 42.4551C12.0691 42.5565 12.3628 42.7205 12.6156 42.9374L25.0111 52.9734C25.3751 53.2687 25.6484 53.6607 25.7996 54.1043C25.9509 54.5479 25.9738 55.0252 25.8659 55.4813C25.758 55.9374 25.5236 56.3539 25.1897 56.6827C24.8557 57.0116 24.4357 57.2395 23.978 57.3404ZM82.373 44.5605C81.915 44.66 81.4382 44.6283 80.9974 44.469C80.5566 44.3097 80.1697 44.0293 79.8811 43.66C79.5926 43.2906 79.4141 42.8474 79.3662 42.3811C79.3182 41.9149 79.4029 41.4446 79.6103 41.0243L86.6806 26.7281C86.9758 26.1401 87.4916 25.6928 88.1154 25.4838C88.7393 25.2748 89.4205 25.3212 90.0103 25.6127C90.6001 25.9042 91.0506 26.4172 91.2634 27.0398C91.4763 27.6623 91.4342 28.3438 91.1464 28.9354L84.0761 43.2316C83.9102 43.5667 83.6709 43.8602 83.3761 44.0903C83.0812 44.3203 82.7384 44.481 82.373 44.5605ZM60.3208 13.6899C60.3208 13.6899 54.6187 22.5871 47.319 24.1847C40.0193 25.7822 31.1221 20.0801 31.1221 20.0801L39.7162 36.0477L45.8177 28.9753L59.7963 92.8475C59.9375 93.4928 60.3293 94.0556 60.8855 94.4121C61.4417 94.7685 62.1167 94.8894 62.762 94.7482C63.4074 94.607 63.9702 94.2152 64.3266 93.659C64.6831 93.1028 64.804 92.4278 64.6627 91.7825L50.6841 27.9103L59.182 31.7875L60.3208 13.6899Z"
                        fill="#9266CC" />
                </g>
                <defs>
                    <clipPath id="clip0_42_37">
                        <rect width="89.6693" height="89.6693" fill="white"
                            transform="translate(0.325867 19.1707) rotate(-12.3447)" />
                    </clipPath>
                </defs>
            </svg>

            <svg width="83" height="83" viewBox="0 0 83 83" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="icon-cleaning">
                <g clip-path="url(#clip0_42_41)">
                    <path
                        d="M42.356 26.0836C42.2545 22.5498 43.5609 19.1204 45.9879 16.5498C48.4149 13.9792 51.7636 12.4781 55.2974 12.3765L58.6285 12.2808L58.3413 2.28764L21.6997 3.3405L21.9869 13.3337C23.7538 13.2829 25.4685 13.9361 26.7537 15.1496C28.039 16.3631 28.7896 18.0374 28.8404 19.8043L29.4147 39.7907C29.4655 41.5576 28.8122 43.2723 27.5988 44.5576C26.3853 45.8429 24.7109 46.5935 22.944 46.6442L23.9011 79.9548L60.5428 78.9019L59.8728 55.5845L59.3814 55.3086C47.9748 47.5919 42.7389 39.4078 42.356 26.0836ZM42.356 26.0836L29.0318 26.4665M51.9784 12.8919L52.1099 17.4688C52.1734 19.6774 53.1116 21.7704 54.7182 23.2873C56.3248 24.8041 58.4682 25.6206 60.6769 25.5572M68.2866 0.334969L68.6695 13.6592"
                        stroke="#F05F4C" stroke-width="3" />
                </g>
                <defs>
                    <clipPath id="clip0_42_41">
                        <rect width="79.9783" height="79.9783" fill="white"
                            transform="translate(0 2.29712) rotate(-1.64588)" />
                    </clipPath>
                </defs>
            </svg>

            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="icon-drop">
                <path
                    d="M57.2755 36.77C62.8295 44.9803 61.1574 53.6451 52.947 59.1992C44.7367 64.7533 36.0719 63.0811 30.5178 54.8708C24.5577 46.0603 26.1026 27.6781 26.7167 22.2479C26.7387 22.0548 26.8022 21.8688 26.9029 21.7027C27.0036 21.5365 27.139 21.3941 27.2999 21.2852C27.4609 21.1764 27.6435 21.1036 27.8352 21.072C28.0268 21.0404 28.2231 21.0507 28.4105 21.1021C33.6784 22.5533 51.3154 27.9594 57.2755 36.77Z"
                    stroke="#0697FF" stroke-width="3.58944" stroke-miterlimit="10" />
                <path
                    d="M52.5754 41.0328C53.7756 42.807 54.2218 44.9852 53.8159 47.0884C53.4101 49.1915 52.1853 51.0473 50.4112 52.2474"
                    stroke="#0697FF" stroke-width="3.58944" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </section>

    <section class="scroll-banner">
        <div class="scroll-track">
            <div class="scroll-content">
                <div class="scroll-item">✨ Planifiez votre collecte</div>
                <div class="scroll-item">✨ Lavage écoresponsable</div>
                <div class="scroll-item">
                    ✨ Collecte & livraison en 48h chrono !
                </div>
                <div class="scroll-item">✨ Paiement en ligne</div>

                <!-- Cloné pour effet continu -->
                <div class="scroll-item">✨ Planifiez votre collecte</div>
                <div class="scroll-item">✨ Lavage écoresponsable</div>
                <div class="scroll-item">
                    ✨ Collecte & livraison en 48h chrono !
                </div>
                <div class="scroll-item">✨ Paiement en ligne</div>
            </div>
        </div>
    </section>

    <section class="section-steps container d-flex flex-column flex-lg-row align-items-center gap-5" id="ccm">
        <div class="steps-content">
            <h2 class="section-title">
                Comment <span class="highlight">ça marche</span> ?
            </h2>
            <p class="section-desc">
                Un service simple, rapide et sans effort en 3 étapes :
            </p>

            <div class="steps-list">
                <div class="step step-purple">
                    <h3>1. Je planifie ma collecte en ligne</h3>
                    <p>
                        Choisissez la date, l'heure et le lieu de collecte :
                        domicile ou bureau.
                    </p>
                </div>
                <div class="step step-white">
                    <h3>2. On récupère mon linge à l’adresse choisie</h3>
                    <p>
                        Notre livreur passe à l’heure convenue. Plus besoin
                        de vous déplacer.
                    </p>
                </div>
                <div class="step step-white wide">
                    <h3>3. Je reçois mon linge propre, repassé et plié</h3>
                    <p>
                        En 48h, votre linge est prêt à l’emploi, livré avec
                        soin.
                    </p>
                </div>
            </div>
        </div>

        <div class="steps-image text-center text-lg-end">
            <img src="./images/ccm.png" alt="Femme surprise avec du linge" class="img-fluid rounded-custom"
                style="max-width: 500px" />
        </div>
    </section>

    <section class="section-why">
        <div class="container">
            <h2 class="section-title" id="avantage">
                Pourquoi choisir <span class="highlight">KLIN KLIN ?</span>
            </h2>
            <p class="section-subtitle">
                Offrez-vous une expérience de blanchisserie simple, rapide
                et professionnelle. <br />
                Découvrez ce qui rend notre service unique.
            </p>

            <div class="cards-grid">
                <div class="card">
                    <h3>👕 Collecte de vêtement</h3>
                    <p class="mt-4">
                        Ne perdez plus de temps à vous déplacer : nous venons chercher votre linge directement chez vous ou
                        sur votre lieu de travail, sans frais supplémentaires.
                    </p>
                    <a href="#" class="card-link">En savoir plus →</a>
                </div>

                <div class="card card-highlight">
                    <h3 class="text-color-highlight">
                        🧼 Lavage professionnel
                    </h3>
                    <p class="mt-4 text-color-highlight">
                        Chaque vêtement est traité avec soin
                        selon ses besoins : lavage à la main, nettoyage doux ou pressing. Nous
                        utilisons des machines et produits
                        de qualité professionnelle.
                    </p>
                    <a href="#" class="card-link dark">En savoir plus →</a>
                </div>

                <div class="card">
                    <h3>🚚 Livraison rapide</h3>
                    <p class="mt-4">
                        Votre linge propre et repassé vous est retourné en seulement deux jours. Fini
                        les longues attentes !
                    </p>
                    <a href="#" class="card-link">En savoir plus →</a>
                </div>

                <div class="card">
                    <h3>💳 Paiement sécurisé</h3>
                    <p class="mt-4">
                        Payez en toute tranquillité via carte bancaire, mobile money ou en espèces
                        à la livraison. Toutes les transactions sont protégées.
                    </p>
                    <a href="#" class="card-link">En savoir plus →</a>
                </div>

                <div class="card">
                    <h3>📦 Option abonnement</h3>
                    <p class="mt-4">
                        Choisissez la solution qui vous convient : optez pour un abonnement régulier ou payez à chaque
                        commande, selon vos besoins.
                    </p>
                    <a href="#" class="card-link">En savoir plus →</a>
                </div>

                <div class="card">
                    <h3>🌱 Produits respectueux</h3>
                    <p class="mt-4">
                        Nous privilégions des lessives écologiques, biodégradables et sans produits agressifs, pour le
                        respect de votre peau et de la planète.
                    </p>
                    <a href="#" class="card-link">En savoir plus →</a>
                </div>
            </div>
        </div>
    </section>

    <testimonial-carousel></testimonial-carousel>
    
    <blog-carousel></blog-carousel>


    <section class="faq-section container">
        <div class="faq-header text-center">
            <h2 class="faq-title" id="faq">FAQs</h2>
            <p class="faq-subtitle">
                Toutes les réponses à vos questions pour une expérience sans
                souci.
            </p>
        </div>

        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-question">
                    Quels vêtements sont acceptés ?
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    Tous les vêtements du quotidien sauf ceux très fragiles
                    ou nécessitant un traitement spécial.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Dois-je trier mon linge ?
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    Ce n’est pas nécessaire. Nous nous occupons du tri selon
                    le type de linge et de traitement.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Quels sont les délais ?
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    La collecte et la livraison sont réalisées sous 48h
                    ouvrées dans la plupart des cas.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Quels moyens de paiement ?
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    Nous acceptons les cartes bancaires, Apple Pay, Google
                    Pay et les paiements via notre application.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Puis-je annuler une collecte ?
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    Oui, jusqu’à 2h avant le créneau choisi, directement
                    depuis votre espace personnel.
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-content">
            <h2>Prêt à dire adieu à la corvée de linge ?</h2>
            <p>
                Confiez-nous votre linge et retrouvez du temps pour ce qui
                compte vraiment.
            </p>
            <div class="cta-buttons">
                <button class="btn btn-collecte">
                    Planifier ma collecte
                </button>
                <button class="btn btn-mint">Faire une simulation</button>
            </div>
        </div>
        <img src="./images/machine.png" alt="Machine à laver illustration" class="cta-image" />
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo-col">
                <a class="navbar-brand" href="/">
                    <svg width="85" height="113" viewBox="0 0 85 113" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_7_511)">
                            <path d="M73.2632 34.0097V33.6897L76.6101 33.4155L73.2632 34.0097Z" fill="#C10606" />
                            <path
                                d="M0.504333 32.2269L19.76 21.9875L40.0243 18.2391H41.6289V9.82807L44.609 9.46238L47.1305 5.39401L43.2794 2.74272L39.0615 7.17678L36.2648 6.26254L43.2336 0L48.3684 5.48544L44.9299 13.9879L47.1305 18.6505L66.7071 20.1133L85 33.7354L77.0685 35.0154L64.7357 23.8159L40.6203 23.176L25.2158 27.4729L15.2212 33.964L0.504333 32.2269Z"
                                fill="#684289" />
                            <path
                                d="M3.39268 29.3928L21.548 19.0162L41.6289 15.3135L43.3711 15.2678V8.68527L46.2136 8.45671L48.5518 4.84547L44.5631 2.55987L40.8495 6.62824L37.9612 5.714L44.8841 0L49.9731 4.89118L46.6721 11.0166L48.9186 15.6792L67.4407 18.9248L85 30.2613L78.7649 31.8155L66.4779 20.8904L42.3625 20.2047L26.9579 24.5016L16.9633 31.0384L3.39268 29.3928Z"
                                fill="#461871" />
                            <path
                                d="M80.3236 86.807L74.3177 92.4753L68.8161 93.1152L67.8075 89.6869L66.7071 93.2067H62.0766L62.3975 109.389L53.7783 111.309L54.3285 93.7552L50.8441 93.6638V97.8236L46.0302 106.189L41.5831 100.338L41.904 91.4239L36.6316 91.9724L36.6775 110.714L28.5626 113L28.8377 93.2981L19.8058 94.9894L18.7055 93.2524L18.2929 95.3094L1.52588e-05 98.0979L2.84252 63.4939H0.596024V39.7694L8.34414 33.7354L16.5049 35.3353L21.9606 32.6383L39.4283 34.2382L39.6575 40.4093L44.9757 35.9753L67.7616 34.1468L69.4579 37.1181L69.137 37.3924L69.1829 37.4838L73.2632 33.6897V44.752L80.0027 56.7742L75.418 62.6711L80.3236 86.807Z"
                                fill="#684289" />
                            <path
                                d="M22.3274 44.9806L29.5254 57.3685L21.2729 58.8313L16.0464 51.4259L15.6796 59.2884L8.34413 59.3798L8.57337 32.4098L16.9175 33.0954L16.5507 41.0493L21.9606 32.6383L30.534 33.4154L22.3274 44.9806Z"
                                fill="#BA9D9D" />
                            <path
                                d="M46.0302 48.4547L45.3884 56.2257L36.815 56.8657H36.7692L30.534 57.4142L31.13 32.9126H40.2994L38.9698 48.4547H46.0302Z"
                                fill="#BA9D9D" />
                            <path d="M54.3744 57.6885L46.9013 58.0085V34.1926L56.4375 33.7354L54.3744 57.6885Z"
                                fill="#BA9D9D" />
                            <path
                                d="M81.6532 33.2783L80.3236 57.0485L71.0626 58.0085L66.2486 45.6205L65.6068 58.0999H57.5378L58.1338 33.0955L66.5237 32.9126L66.9822 32.6841L73.034 43.7006L73.2632 34.0097L73.3091 33.5069L81.6532 33.2783Z"
                                fill="#BA9D9D" />
                            <path
                                d="M27.5539 17.9191L30.5798 17.3705L31.8635 18.1019L34.706 22.0332L35.027 36.3867L30.534 35.9753V22.3532L30.0755 20.7532L27.5539 17.9191Z"
                                fill="#684289" />
                            <path
                                d="M53.0447 16.4106L55.6122 16.8677L57.2168 17.142L60.1968 20.7533L60.6095 35.6554L55.5663 35.9753L55.9331 20.8904L55.1995 19.0162L53.0447 16.4106Z"
                                fill="#684289" />
                            <path
                                d="M41.7664 15.2678H43.3711L46.3053 17.7363L48.9186 15.6792L50.6607 15.9992L48.0933 20.0676L48.6893 35.9296L44.5173 36.3868L45.4342 20.3419L41.7664 15.2678Z"
                                fill="#684289" />
                            <path
                                d="M22.3274 74.7848L29.5254 87.127L21.2729 88.5898L16.0464 81.2302L15.6796 89.0469L8.34413 89.1841L8.57337 62.1683L16.9175 62.854L16.5507 70.8535L21.9606 62.4425L30.534 63.1739L22.3274 74.7848Z"
                                fill="#8DFFC8" />
                            <path
                                d="M46.0302 78.2132L45.3884 86.0299L36.815 86.6242H36.7692L30.534 87.1727L31.13 62.6711H40.2994L38.9698 78.2132H46.0302Z"
                                fill="#8DFFC8" />
                            <path d="M54.3744 87.447L46.9013 87.767V63.951L56.4375 63.4939L54.3744 87.447Z"
                                fill="#8DFFC8" />
                            <path
                                d="M81.6532 63.0368L80.3236 86.807L71.0626 87.767L66.2486 75.379L65.6068 87.8584H57.5378L58.1338 62.7168H66.5237H67.028L73.034 73.4591L73.3091 63.2654L81.6532 63.0368Z"
                                fill="#8DFFC8" />
                            <path
                                d="M22.3274 44.9806L29.5254 57.3685L21.2729 58.8313L16.0464 51.4259L15.6796 59.2884L8.34413 59.3798L8.57337 32.4098L16.9175 33.0954L16.5507 41.0493L21.9606 32.6383L30.534 33.4154L22.3274 44.9806Z"
                                fill="#8DFFC8" />
                            <path
                                d="M46.0302 48.4547L45.3884 56.2257L36.815 56.8657H36.7692L30.534 57.4142L31.13 32.9126H40.2994L38.9698 48.4547H46.0302Z"
                                fill="#8DFFC8" />
                            <path d="M54.3744 57.6885L46.9013 58.0085V34.1926L56.4375 33.7354L54.3744 57.6885Z"
                                fill="#8DFFC8" />
                            <path
                                d="M81.6532 33.2783L80.3236 57.0485L71.0626 58.0085L66.2486 45.6205L65.6068 58.0999H57.5378L58.1338 32.9126H66.5237H67.028L73.034 43.7006L73.3091 33.5069L81.6532 33.2783Z"
                                fill="#8DFFC8" />
                        </g>
                        <defs>
                            <clipPath id="clip0_7_511">
                                <rect width="85" height="113" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </a>
                <p class="footer-desc">
                    Tout-en-un pour faire collecter,<br />
                    laver et livrer votre linge en toute simplicité.
                </p>
                <div class="footer-socials">
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
                </div>
                <div class="footer-lang-dropdown">
                    <select name="language" id="language-select">
                        <option value="fr">🇫🇷 Français</option>
                        <option value="en">🇬🇧 English</option>
                    </select>
                </div>
            </div>

            <div class="footer-links-col">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="#ccm">Comment ça marche&nbsp;?</a></li>
                    <li>
                        <a href="#avantage">Pourquoi choisir KLIN KLIN&nbsp;?</a>
                    </li>
                    <li><a href="#temoignages">Témoignages</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h4>Ressources</h4>
                <ul>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#">Centre d’aide</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Politique de confidentialité</a></li>
                    <li><a href="#">Termes et conditions</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>
                Copyright © 2025 KLIN KLIN - A.Fabrice. Tous droits
                réservés.
            </p>
            <div class="footer-bottom-links">
                <a href="#">Terms & Conditions</a>
                <a href="#">Privacy Policy</a>
            </div>
        </div>
    </footer>
@endsection
