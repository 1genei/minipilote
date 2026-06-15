<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('depenses', function (Blueprint $table) {
            $table->dropColumn('montant');
            $table->boolean('soumis_tva')->default(true)->after('description');
            $table->double('taux_tva')->nullable()->after('soumis_tva');
            $table->double('montant_ht')->nullable()->after('taux_tva');
            $table->double('montant_tva')->nullable()->after('montant_ht');
            $table->double('montant_ttc')->nullable()->after('montant_tva');
        });
    }

    public function down(): void
    {
        Schema::table('depenses', function (Blueprint $table) {
            $table->dropColumn(['soumis_tva', 'taux_tva', 'montant_ht', 'montant_tva', 'montant_ttc']);
            $table->double('montant')->nullable();
        });
    }
};
