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
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->integer('evenement_id')->nullable();
            $table->integer('circuit_id')->nullable();
            $table->string('nom')->nullable();
            $table->integer('user_id')->nullable();
            $table->date('date')->nullable();
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->integer('duree_session')->nullable(); //en minutes
            $table->integer('nb_creneau_par_session')->nullable(); 
            $table->integer('nb_tour_max_par_session')->nullable(); 
            $table->boolean('a_pause')->default(false);
            $table->time('heure_debut_pause')->nullable();
            $table->time('heure_fin_pause')->nullable();
            $table->string('statut')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('est_modele')->default(false);
            $table->boolean('est_modele_par_defaut')->default(false);
            $table->boolean('est_archive')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plannings');
    }
};
