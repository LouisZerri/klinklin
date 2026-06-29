<?php

return [
    'secret_key' => env('STRIPE_TEST_SECRET_KEY'),
    'public_key' => env('VITE_STRIPE_TEST_PUBLIC_KEY'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    'premium_price_id' => env('STRIPE_PREMIUM_PRICE_ID'),
];
