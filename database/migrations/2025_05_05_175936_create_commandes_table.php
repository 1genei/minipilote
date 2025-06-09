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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->integer('evenement_id')->nullable();
            $table->integer('devi_id')->nullable();
            $table->string('numero_commande');
            $table->string('nom_commande')->nullable();
            $table->date('date_commande')->nullable();
            $table->integer('duree_validite')->nullable();
            $table->date('date_realisation_prevue')->nullable();
            $table->date('date_realisation_reelle')->nullable();
            $table->string('statut_commande')->nullable(); 
            $table->string('type')->nullable();
            $table->double('montant_ht')->nullable();
            $table->double('montant_ttc')->nullable();
            $table->double('montant_tva')->nullable();
            $table->boolean('sans_tva')->default(false);
            $table->double('net_a_payer')->nullable();
            $table->string('type_remise')->nullable();
            $table->double('remise')->nullable();
            $table->double('montant_remise')->nullable();
            $table->integer('collaborateur_id')->nullable();
            $table->integer('client_prospect_id')->nullable();
            $table->text('palier')->nullable();
            $table->text('url_pdf')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->string('statut_paiement')->nullable();
            $table->string('origine_commande')->nullable();
            $table->string('numero_origine')->nullable();
            $table->date('date_origine_commande')->nullable();
            $table->boolean('archive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
