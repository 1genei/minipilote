<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entites', function (Blueprint $table) {
            $table->id();
            $table->integer("contact_id")->unsigned()->nullable();
            // CE, groupe de personne, autre
            $table->string("type")->nullable();
            $table->string("nom")->nullable();
            $table->string('forme_juridique')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string("email")->nullable();
            $table->string('indicatif_fixe')->nullable();
            $table->string('indicatif_mobile')->nullable();
            $table->string('telephone_fixe')->nullable();
            $table->string('telephone_mobile')->nullable();           
            $table->string("site_web")->nullable();
            
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
            
            $table->string('numero_siret')->nullable();
            $table->string('numero_siren')->nullable();
            $table->string('code_naf')->nullable();
            $table->date('date_immatriculation')->nullable();
            $table->string('numero_rsac')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('numero_tva')->nullable();
            $table->string('numero_rcs')->nullable();
            $table->string('rib_bancaire')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
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
        Schema::dropIfExists('entites');
    }
}
