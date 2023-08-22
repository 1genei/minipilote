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
        Schema::create('categorieproduits', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();
            $table->integer("parent_id")->nullable();
            $table->string("description")->nullable();
            $table->integer("niveau")->nullable();
            $table->boolean("archive")->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorieproduits');
    }
};
