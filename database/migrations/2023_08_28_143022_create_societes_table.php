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
        Schema::create('societes', function (Blueprint $table) {
            $table->id();
            $table->string("raison_sociale")->nullable();
            $table->string("numero_siret")->nullable();
            $table->string("logo")->nullable();
            $table->string("capital")->nullable();
            $table->string("forme_juridique")->nullable();
            $table->string("gerant")->nullable();
            $table->string("numero_tva")->nullable();
            $table->string("email")->nullable();
            $table->string("telephone")->nullable();
            
            $table->string("numero_voie")->nullable();
            $table->string("nom_voie")->nullable();
            $table->string("complement_voie")->nullable();
            $table->string("code_postal")->nullable();
            $table->string("ville")->nullable();
            $table->string("pays")->nullable();
            $table->string("code_insee")->nullable();
            $table->string("code_cedex")->nullable();
            $table->string("numero_cedex")->nullable();
            $table->string("boite_postale")->nullable();
            $table->string("residence")->nullable();
            $table->string("batiment")->nullable();
            $table->string("escalier")->nullable();
            $table->string("etage")->nullable();
            $table->string("porte")->nullable();
            
            
            $table->boolean("est_societe_principale")->nullable()->default(false);
            $table->boolean("archive")->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societes');
    }
};
