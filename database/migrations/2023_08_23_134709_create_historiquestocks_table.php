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
        Schema::create('historiquestocks', function (Blueprint $table) {
            $table->id();
            $table->integer("produit_id")->nullable();
            // modif, commande client
            $table->string("motif")->nullable();
            $table->integer("stock_id")->nullable();
            // ajout ou retrait
            $table->integer("quantite")->nullable();
            $table->integer("user_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiquestocks');
    }
};
