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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number');
            $table->string('address');
            $table->string('complement')->nullable();
            $table->string('city');
            $table->string('zip_code');
            $table->date('order_date');
            $table->string('timeslot');
            $table->enum('status', ['Prévu', 'Collecté', 'En nettoyage', 'Sortir pour livraison', 'Livré', 'En attente', 'Annulée']);
            $table->decimal('subtotal', 8, 2);
            $table->decimal('expedition', 8, 2)->default(10);
            $table->decimal('tax', 8, 2)->default(5);
            $table->string('promo_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
