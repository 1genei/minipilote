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
        Schema::create('entitexs', function (Blueprint $table) {
            $table->id();
              // entreprise, CE, groupe de personne, autre
              $table->string("type")->nullable();
              $table->string("nom")->nullable();
              $table->string("email")->nullable();
              $table->string("contact1")->nullable();
              $table->string("contact2")->nullable();
              $table->string("adresse")->nullable();
              $table->string("code_postal")->nullable();
              $table->string("ville")->nullable();        
              $table->integer("contact_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entitexs');
    }
};
