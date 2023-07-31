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
            $table->string("adresse")->nullable();
            $table->string("complement_adresse")->nullable();
            $table->string("code_postal")->nullable();
            $table->string("ville")->nullable();
            $table->string("pays")->nullable();
            $table->string("profession")->nullable();
            $table->date("date_naissance")->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->nullable();

            // couple
            $table->string('civilite1')->nullable();
            $table->string('nom1')->nullable();
            $table->string('prenom1')->nullable();
            $table->string('indicatif_fixe1')->nullable();
            $table->string('indicatif_mobile1')->nullable();
            $table->string('telephone_fixe1')->nullable();
            $table->string('telephone_mobile1')->nullable();
            $table->string('email1')->nullable();

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
