<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planning_creneaux', function (Blueprint $table) {
            $table->unsignedBigInteger('instructeur_id')->nullable()->after('heure');
            $table->foreign('instructeur_id')->references('id')->on('contacts')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('planning_creneaux', function (Blueprint $table) {
            $table->dropForeign(['instructeur_id']);
            $table->dropColumn('instructeur_id');
        });
    }
};
