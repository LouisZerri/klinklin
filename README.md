# KLIN KLIN

Application web d'un **service de pressing à domicile** : collecte, lavage et livraison du linge.
L'utilisateur planifie une collecte, choisit ses articles, paie en ligne, reçoit une facture, et
peut souscrire un abonnement Premium.

> ⚠️ **Statut : hors production.**
> Ce service a été **arrêté par l'entreprise** : le site n'est donc plus en ligne.
> J'en conserve une **copie fonctionnelle à des fins de démonstration**, dans le cadre de mon portfolio.
> Les paiements fonctionnent en **mode test Stripe** — aucune transaction réelle n'est effectuée.

---

## ✨ Fonctionnalités

- **Authentification** : inscription, connexion, mot de passe oublié / réinitialisation
- **Parcours de commande** : adresse & créneau → sélection d'articles → récapitulatif → paiement
- **Paiement en ligne** sécurisé via **Stripe** (mode test) + **webhook** de confirmation
- **Facturation PDF** automatique + historique des factures (téléchargement, archive ZIP)
- **Espace personnel** : profil (avec photo), sécurité (mot de passe), notifications, aide & support
- **Commandes** : liste filtrable, historique, détails avec suivi de livraison
- **Abonnement Premium** (livraison offerte, −10 %, collecte prioritaire…) via Stripe récurrent
- **Simulateur de tarif** public, blog / conseils, pages légales, pages d'erreur personnalisées

## 🛠️ Stack technique

- **Backend** : Laravel 12 (PHP 8.4)
- **Frontend** : Blade, Vue 3, Vite, Tailwind CSS
- **Base de données** : MySQL
- **Paiement** : Stripe (mode test) — `stripe/stripe-php`
- **PDF** : `barryvdh/laravel-dompdf`
- **Tests** : PHPUnit

## 🚀 Installation locale

### Prérequis
PHP 8.2+, Composer, Node.js 18+, MySQL

### Étapes

```bash
git clone git@github.com:LouisZerri/klinklin.git
cd klinklin

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Configurer la connexion MySQL dans `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), puis :

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

L'application est disponible sur **http://localhost:8000**.

**Compte de démonstration** : `test@example.com` / `password`

### Configuration Stripe (mode test)

Renseigner les clés de **test** dans `.env` :

```dotenv
STRIPE_TEST_SECRET_KEY=sk_test_xxx
VITE_STRIPE_TEST_PUBLIC_KEY=pk_test_xxx
STRIPE_WEBHOOK_SECRET=whsec_xxx
STRIPE_PREMIUM_PRICE_ID=price_xxx
```

Pour recevoir les webhooks en local (confirmation de paiement et d'abonnement) :

```bash
stripe listen --forward-to localhost:8000/stripe/webhook
```

> 💳 Carte de test : `4242 4242 4242 4242`, date future quelconque, CVC quelconque.

## ✅ Tests

```bash
php artisan test
```

## 📄 Licence

Projet de démonstration — usage portfolio.
