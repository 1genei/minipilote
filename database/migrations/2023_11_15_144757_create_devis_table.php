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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->string('numero_devis');
            $table->string('nom_devis')->nullable();
            $table->date('date_devis')->nullable();
            $table->integer('duree_validite')->nullable();
            $table->string('statut')->nullable();
            $table->string('type')->nullable();
            $table->double('montant_ht')->nullable();
            $table->double('montant_ttc')->nullable();
            $table->double('montant_tva')->nullable();
            $table->boolean('sans_tva')->default(false);
            $table->double('net_a_payer')->nullable();
            $table->string('type_remise')->nullable();
            $table->double('remise')->nullable();
            $table->double('montant_remise')->nullable();
            $table->double('montant_remise_total')->nullable();
            $table->integer('collaborateur_id')->nullable();
            $table->integer('client_prospect_id')->nullable();
            $table->text('url_pdf')->nullable();
            $table->boolean('archive')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
