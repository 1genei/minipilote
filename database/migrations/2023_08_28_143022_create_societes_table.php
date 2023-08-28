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
            $table->string("gerant")->nullable();
            $table->string("numero_tva")->nullable();
            $table->string("email")->nullable();
            $table->string("telephone")->nullable();
            $table->string("adresse")->nullable();
            $table->string("complement_adresse")->nullable();
            $table->string("ville")->nullable();
            $table->string("code_postal")->nullable();
            $table->string("pays")->nullable();
            $table->string("est_societe_principale")->nullable();
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
