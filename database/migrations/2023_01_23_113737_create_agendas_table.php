<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->string('type_rappel')->nullable();
            $table->text('description')->nullable();
            $table->integer('user_id')->nullable();            
            $table->date('date_deb')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('heure_deb')->nullable();
            $table->string('heure_fin')->nullable();
            $table->boolean('est_lie')->default(false);
            $table->integer('contact_id')->nullable();
            $table->boolean('est_terminee')->default(false);
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
        Schema::dropIfExists('agendas');
    }
}
