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
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individus');
    }
}
