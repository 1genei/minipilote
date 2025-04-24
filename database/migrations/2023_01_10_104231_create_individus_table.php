<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individus', function (Blueprint $table) {
            $table->id();
            $table->integer("contact_id")->unsigned()->nullable();
            $table->string('civilite')->nullable();
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->string('nom_jeune_fille')->nullable();
            $table->string("email")->nullable();
            $table->string('indicatif_fixe')->nullable();
            $table->string('indicatif_mobile')->nullable();
            $table->string('telephone_fixe')->nullable();
            $table->string('telephone_mobile')->nullable();
            
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
            
            $table->string("profession")->nullable();
            $table->string("region")->nullable();

            $table->string("fonction_entreprise")->nullable();
            $table->string("entreprise")->nullable();
            $table->string("site_web_entreprise")->nullable();
            $table->string("effectif_entreprise")->nullable();

            $table->string("adresse_entreprise")->nullable();
            $table->string("code_postal_entreprise")->nullable();
            $table->string("ville_entreprise")->nullable();
            $table->string("pays_entreprise")->nullable();

            $table->date("date_naissance")->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->nullable();

            $table->string("linkedin")->nullable();
            $table->string("twitter")->nullable();
            $table->string("facebook")->nullable();
            $table->string("instagram")->nullable();
            $table->string("youtube")->nullable();
            $table->string("tiktok")->nullable();
            
            // couple
            $table->string('civilite1')->nullable();
            $table->string('nom1')->nullable();
            $table->string('prenom1')->nullable();
            $table->string('indicatif_fixe1')->nullable();
            $table->string('indicatif_mobile1')->nullable();
            $table->string('telephone_fixe1')->nullable();
            $table->string('telephone_mobile1')->nullable();
            $table->string('email1')->nullable();
            $table->string('profession1')->nullable();
            $table->string('profession2')->nullable();

            $table->string('civilite2')->nullable();
            $table->string('nom2')->nullable();
            $table->string('prenom2')->nullable();
            $table->string('indicatif_fixe2')->nullable();
            $table->string('indicatif_mobile2')->nullable();
            $table->string('telephone_fixe2')->nullable();
            $table->string('telephone_mobile2')->nullable();
            $table->string('email2')->nullable();

            $table->text("notes")->nullable();
            $table->boolean("archive")->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individus');
    }
}
