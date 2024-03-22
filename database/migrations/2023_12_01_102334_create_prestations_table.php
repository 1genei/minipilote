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
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->nullable();
            $table->string('nom')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('produit_id')->nullable();
            $table->integer('voiture_id')->nullable();
            $table->integer('beneficiaire_id')->nullable();
            $table->boolean('client_est_beneficiaire')->default(false);
            $table->integer('user_id')->nullable();
            $table->integer('evenement_id')->nullable();
            $table->date('date_prestation')->nullable();
            $table->string('methode_paiement')->nullable();
            $table->double('montant_ht')->nullable();
            $table->double('montant_ttc')->nullable();
            $table->double('montant_tva')->nullable();
            $table->string('statut')->default('En attente')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('archive')->default(false);
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestations');
    }
};
