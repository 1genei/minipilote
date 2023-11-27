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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande');
            $table->date('date_commande')->nullable();
            $table->date('date_livraison')->nullable();
            $table->string('statut')->nullable();
            $table->string('type')->nullable();
            $table->string('mode_livraison')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->string('modalite_paiement')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
