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
        Schema::create('modelevoitures', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->double('cout_kilometrique')->nullable(); 
            $table->double('coefficient_prix')->nullable(); 
            $table->double('prix_vente_kilometrique')->nullable(); 
            // seuil_alerte à partir duquel on doit changer les pneus, vidanger, etc.
            $table->integer('seuil_alerte_km_pneu')->nullable();
            $table->integer('seuil_alerte_km_vidange')->nullable();
            $table->integer('seuil_alerte_km_revision')->nullable();
            $table->integer('seuil_alerte_km_courroie')->nullable();
            $table->integer('seuil_alerte_km_frein')->nullable();
            $table->integer('seuil_alerte_km_amortisseur')->nullable();
            $table->boolean('archive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelevoitures');
    }
};
