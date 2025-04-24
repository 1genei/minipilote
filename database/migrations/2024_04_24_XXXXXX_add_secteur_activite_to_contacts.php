<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreignId('secteur_activite_id')->nullable()->constrained('secteur_activite')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['secteur_activite_id']);
            $table->dropColumn('secteur_activite_id');
        });
    }
}; 