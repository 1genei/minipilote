<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            // Entite ou individu
            $table->string("type")->nullable();
            // Le user qui a crée le contact
            $table->integer('user_id')->unsigned()->nullable();
            // Le commercial qui suit le contact
            $table->integer('commercial_id')->unsigned()->nullable();
            // société lié au contact
            $table->integer('societe_id')->unsigned()->nullable();
            // 'Personne physique', 'couple', 'Personne morale', 'groupe', 'autre'
            $table->string("nature")->nullable();
            $table->string("source_contact")->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
