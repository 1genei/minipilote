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
        Schema::create('valeurcaracteristiques', function (Blueprint $table) {
            $table->id();
            $table->integer("caracteristique_id")->nullable();
            $table->string("nom")->nullable();
            $table->double("valeur")->nullable();
            $table->boolean("archive")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valeurcaracteristiques');
    }
};
