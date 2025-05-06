<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Index pour la table contacts
        Schema::table('contacts', function (Blueprint $table) {
            $table->index('type');
            $table->index('archive');
            $table->index(['type', 'archive']);
            $table->index('user_id');
            $table->index('commercial_id');
            $table->index('secteur_activite_id');
        });

        // Index pour la table individus
        Schema::table('individus', function (Blueprint $table) {
            $table->index('contact_id');
            $table->index('nom');
            $table->index('prenom');
            $table->index('email');
            $table->index(['nom', 'prenom']);
        });

        // Index pour la table entites
        Schema::table('entites', function (Blueprint $table) {
            $table->index('contact_id');
            $table->index('raison_sociale');
            $table->index('email');
        });

        // Index pour les tables pivot
        Schema::table('contact_typecontact', function (Blueprint $table) {
            $table->index(['contact_id', 'typecontact_id']);
        });

        Schema::table('contact_tag', function (Blueprint $table) {
            $table->index(['contact_id', 'tag_id']);
        });
    }

    public function down()
    {
        // Supprimer les index de la table contacts
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['archive']);
            $table->dropIndex(['type', 'archive']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['commercial_id']);
            $table->dropIndex(['secteur_activite_id']);
        });

        // Supprimer les index de la table individus
        Schema::table('individus', function (Blueprint $table) {
            $table->dropIndex(['contact_id']);
            $table->dropIndex(['nom']);
            $table->dropIndex(['prenom']);
            $table->dropIndex(['email']);
            $table->dropIndex(['nom', 'prenom']);
        });

        // Supprimer les index de la table entites
        Schema::table('entites', function (Blueprint $table) {
            $table->dropIndex(['contact_id']);
            $table->dropIndex(['raison_sociale']);
            $table->dropIndex(['email']);
        });

        // Supprimer les index des tables pivot
        Schema::table('contact_typecontact', function (Blueprint $table) {
            $table->dropIndex(['contact_id', 'typecontact_id']);
        });

        Schema::table('contact_tag', function (Blueprint $table) {
            $table->dropIndex(['contact_id', 'tag_id']);
        });
    }
}; 