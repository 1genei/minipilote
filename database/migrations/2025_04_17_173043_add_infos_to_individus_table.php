<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('individus', function (Blueprint $table) {
            $table->string("fonction_entreprise")->nullable();
            $table->string("entreprise")->nullable();
            $table->string("site_web_entreprise")->nullable();

            $table->string("adresse_entreprise")->nullable();
            $table->string("code_postal_entreprise")->nullable();
            $table->string("ville_entreprise")->nullable();
            $table->string("pays_entreprise")->nullable();

            $table->string("linkedin")->nullable();
            $table->string("twitter")->nullable();
            $table->string("facebook")->nullable();
            $table->string("instagram")->nullable();
            $table->string("youtube")->nullable();
            $table->string("tiktok")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individus', function (Blueprint $table) {
            $table->dropColumn([
                "fonction_entreprise",
                "entreprise",
                "site_web_entreprise",
                "adresse_entreprise",
                "code_postal_entreprise",
                "ville_entreprise",
                "pays_entreprise",
                "linkedin",
                "twitter",
                "facebook",
                "instagram",
                "youtube",
                "tiktok",
            ]);
            //
        });
    }
};
