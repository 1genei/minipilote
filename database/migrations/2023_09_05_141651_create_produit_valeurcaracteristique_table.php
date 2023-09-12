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
        Schema::create('produit_valeurcaracteristique', function (Blueprint $table) {
            $table->id();
            $table->integer('produit_id')->nullable();
            $table->integer('valeurcaracteristique_id')->nullable();
            $table->integer('caracteristique_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_valeurcaracteristique');
    }
};
