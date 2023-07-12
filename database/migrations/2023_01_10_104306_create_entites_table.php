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
            $table->string("email")->nullable();
            $table->string("contact1")->nullable();
            $table->string("contact2")->nullable();
            $table->string("adresse")->nullable();
            $table->string("complement_adresse")->nullable();
            $table->string("code_postal")->nullable();
            $table->string("ville")->nullable();        
            $table->string("site_web")->nullable();        
            $table->text("notes")->nullable();        
            $table->integer("contact_id");
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
