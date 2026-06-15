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
        Schema::create('planning_creneaux', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planning_id');
            $table->unsignedBigInteger('voiture_id');
            $table->unsignedBigInteger('instructeur_id')->nullable();
            $table->string('heure', 5); // format HH:MM
            $table->unsignedSmallInteger('nb_pilotage')->nullable();
            $table->unsignedSmallInteger('nb_bp')->nullable();
            $table->boolean('cam')->default(false);
            $table->boolean('permis')->default(false);
            $table->boolean('decharge')->default(false);
            $table->timestamps();

            // $table->foreign('planning_id')->references('id')->on('plannings')->nullOnDelete();
            // $table->foreign('voiture_id')->references('id')->on('voitures')->nullOnDelete();
            // $table->foreign('instructeur_id')->references('id')->on('contacts')->nullOnDelete();

            $table->unique(['planning_id', 'voiture_id', 'heure']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_creneaux');
    }
};
