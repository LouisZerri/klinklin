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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_url')->nullable();
            $table->enum('type', ['Vêtements', 'Linge de maison', 'Délicat']);
            $table->json('usage');
            $table->decimal('unit_price', 8, 2);
            $table->json('weight_ranges'); // ex: {"léger": [0.15, 0.25], "standard": [0.25, 0.35], "épais": [0.35, 0.5]}
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
