<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planning_placements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planning_id');
            $table->unsignedBigInteger('voiture_id');
            $table->string('heure', 5); // "09:20"
            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('beneficiaire_id')->nullable();
            $table->timestamps();

            $table->foreign('planning_id')->references('id')->on('plannings')->onDelete('cascade');
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade');
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planning_placements');
    }
};
