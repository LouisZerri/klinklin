<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->json('benefits')->nullable()->after('price');
            $table->string('stripe_price_id')->nullable()->after('benefits');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_customer_id')->nullable()->after('subscription_id');
            $table->string('stripe_subscription_id')->nullable()->after('stripe_customer_id');
            $table->string('subscription_status')->nullable()->after('stripe_subscription_id');
            $table->timestamp('subscription_ends_at')->nullable()->after('subscription_status');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['benefits', 'stripe_price_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_customer_id',
                'stripe_subscription_id',
                'subscription_status',
                'subscription_ends_at',
            ]);
        });
    }
};
