<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Entite;
use App\Models\Individu;

class CreateEntiteIndividuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entite_individu', function (Blueprint $table) {
            $table->primary(['entite_id', 'individu_id']);
            $table->foreignIdFor(Entite::class);
            $table->foreignIdFor(Individu::class);
            $table->string("poste")->nullable();            
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
        Schema::dropIfExists('entite_individu');
    }
}
