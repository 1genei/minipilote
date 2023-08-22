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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string("reference")->nullable();
            // Simple, déclinaison
            $table->integer("fournisseur_id")->nullable();
            $table->integer("categorie_id")->nullable();
            $table->integer("marque_id")->nullable();
            $table->string("type")->nullable();
            $table->string("nom")->nullable();
            $table->text("description")->nullable();
            $table->double("poids")->nullable();
            $table->double("longueur")->nullable();
            $table->double("largeur")->nullable();
            $table->double("hauteur")->nullable();
            $table->string("fiche_technique")->nullable();
            $table->double("prix_achat")->nullable();
            $table->double("commission_base")->nullable();
            // ( prix_achat + comm_base) markeup ou marge
            $table->double("prix_achat_commerciaux")->nullable();
            $table->double("prix_vente")->nullable();
            $table->double("prix_vente_max")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
