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
            // entreprise, CE, groupe de personne, autre
            $table->string("type")->nullable();
            $table->string("nom")->nullable();
            $table->string('forme_juridique')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string("email")->nullable();
            $table->string('telephone_fixe')->nullable();
            $table->string('telephone_mobile')->nullable();
            $table->string("adresse")->nullable();
            $table->string("complement_adresse")->nullable();
            $table->string("code_postal")->nullable();
            $table->string("ville")->nullable();
            $table->string("site_web")->nullable();
            $table->string('numero_siret')->nullable();
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
            $table->integer("contact_id")->unsigned()->nullable();
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
