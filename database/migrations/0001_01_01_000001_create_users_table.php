<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default('/images/default-avatar.png');
            $table->string('language')->default('français');
            $table->string('reset_token')->nullable();
            $table->boolean('notification_profil_image')->default(false);
            $table->boolean('notification_ressources_et_formations')->default(false);
            $table->boolean('notification_recommandation_de_produits')->default(false);
            $table->boolean('notification_conseils_et_bonne_pratique')->default(false);
        
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
