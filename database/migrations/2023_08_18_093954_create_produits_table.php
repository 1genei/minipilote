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
            $table->integer("marque_id")->nullable();
            $table->integer("user_id")->nullable();
            $table->string("type")->nullable();
            $table->string("nom")->nullable();
            $table->text("description")->nullable();
            $table->double("poids")->nullable();
            $table->double("longueur")->nullable();
            $table->double("largeur")->nullable();
            $table->double("hauteur")->nullable();
            $table->string("fiche_technique")->nullable();
            $table->double("prix_achat_ht")->nullable();
            $table->double("prix_achat_ttc")->nullable();
            $table->double("commission_base")->nullable();
            // ( prix_achat + comm_base) markeup ou marge
            $table->double("prix_achat_commerciaux_ht")->nullable();
            $table->double("prix_achat_commerciaux_ttc")->nullable();
            $table->double("prix_vente_ht")->nullable();
            $table->double("prix_vente_ttc")->nullable();
            $table->double("prix_vente_max_ht")->nullable();
            $table->double("prix_vente_max_ttc")->nullable();
            $table->boolean("gerer_stock")->default(false);
            $table->boolean("archive")->default(false);
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
