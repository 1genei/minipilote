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
        Schema::create('commande_produit', function (Blueprint $table) {
            $table->id();
            $table->integer('commande_id')->nullable();
            $table->integer('produit_id')->nullable();
            $table->integer('quantite')->nullable();
            $table->double('prix_unitaire')->nullable();
            $table->double('montant_tva')->nullable();
            $table->double('montant_ht')->nullable();
            $table->double('montant_ttc')->nullable();
            $table->double('taux_tva')->nullable();
            $table->double('remise')->nullable();
            $table->double('taux_remise')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_produit');
    }
};
