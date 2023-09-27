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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id')->nullable();
            $table->string('type')->nullable();
            $table->string('nature')->nullable();
            $table->string('statut_juridique')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->boolean('a_parrain')->default(false);
            $table->integer('parrain_id')->nullable();
            $table->text('param_comm_parrain')->nullable();
            $table->text('palier_remuneration')->nullable();

            $table->string('contrat_pdf')->nullable();
            $table->boolean('est_salarie')->default(true);
            $table->double('taux_horaire')->nullable();
            $table->double('salaire_de_base')->nullable();
            $table->double('salaire_net')->nullable();
            $table->boolean('est_actif')->default(true);
            $table->boolean('est_soumis_tva')->default(false);
            $table->boolean('a_demission')->default(false);
            $table->date('date_demission')->nullable();
            $table->boolean('est_fin_droit_suite')->default(false);
            $table->date('date_fin_droit_suite')->nullable();
            $table->date('date_fin_preavis')->nullable();
            $table->boolean('est_modele')->default(false);
            
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
