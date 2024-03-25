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
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('libelle')->nullable();
            $table->text('description')->nullable();
            $table->double('montant')->nullable();
            $table->date('date_depense')->nullable();            
            $table->integer('voiture_id')->nullable();
            $table->integer('fournisseur_id')->nullable();
            $table->integer('evenement_id')->nullable();
            $table->integer('prestation_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('archive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};
