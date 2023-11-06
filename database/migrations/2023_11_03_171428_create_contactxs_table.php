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
        Schema::create('contactxs', function (Blueprint $table) {
            $table->id();
             // Entite ou individu
             $table->string("type")->nullable();
             $table->boolean("est_client")->default(false);
             $table->boolean("est_prospect")->default(false);
             $table->boolean("est_fournisseur")->default(false);
             $table->boolean("archive")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactxs');
    }
};
