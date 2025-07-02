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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->date('date')->nullable();
            $table->string('statut')->nullable(); // 
            $table->string('type')->nullable(); // client, fournisseur, directe
            $table->boolean('a_avoir')->default(false);
            $table->string('nature')->nullable(); // facture, avoir, acompte
            $table->string('mode_paiement')->nullable(); // cash, cheque, virement, carte, etc.
            $table->string('statut_paiement')->nullable(); // payée, attente paiement, partiellement payée
            $table->string('type_paiement')->nullable(); // unique, multiple
            $table->integer('nombre_paiement')->default(1);
            $table->text('paiements')->nullable(); // json: [{"date": "2024-01-01", "montant": 100, "mode": "cheque"}]
            $table->double('montant_ht', 10, 2)->default(0);
            $table->double('montant_tva', 10, 2)->default(0);
            $table->double('montant_ttc', 10, 2)->default(0);
            $table->double('net_a_payer', 10, 2)->default(0);
            $table->double('montant_restant_a_payer', 10, 2)->default(0);
            
            // Remises
            $table->string('type_remise')->nullable(); // pourcentage, montant
            $table->double('remise', 10, 2)->default(0);
            
            // Détails de la facture
            $table->text('palier')->nullable(); // json: lignes de produits/services
            $table->text('description')->nullable(); 
            $table->text('notes')->nullable();
            
            // Fichiers
            $table->string('url_pdf')->nullable();
            $table->string('url_image')->nullable(); // pour factures fournisseurs scannées
            
            // Références
            $table->string('numero_origine')->nullable(); // numéro de la facture fournisseur
            $table->string('reference')->nullable(); // référence interne

            // Relations
            $table->foreignId('client_id')->nullable()->constrained('contacts')->onDelete('set null');
            $table->foreignId('fournisseur_id')->nullable()->constrained('contacts')->onDelete('set null');
            $table->foreignId('devi_id')->nullable()->constrained('devis')->onDelete('set null');
            $table->foreignId('commande_id')->nullable()->constrained('commandes')->onDelete('set null');
            $table->foreignId('evenement_id')->nullable()->constrained('evenements')->onDelete('set null');
            $table->foreignId('prestation_id')->nullable()->constrained('prestations')->onDelete('set null');
            $table->foreignId('depense_id')->nullable()->constrained('depenses')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Factures multiples
            $table->text('commandes_liees')->nullable(); // json: [{"commande_id": 1, "montant": 100}]
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
