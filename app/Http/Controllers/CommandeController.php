<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Contact;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CommandeController extends Controller
{
    public function index()
    {
        return view('commande.index');
    }

    public function archives()
    {
        return view('commande.archives');
    }

    public function create()
    {
        $clients = Contact::whereHas('typecontacts', function($query) {
            $query->whereIn('type', ['Client', 'Prospect']);
        })->where('archive', false)->get();
        
        $collaborateurs = Contact::whereHas('typecontacts', function($query) {
            $query->where('type', 'Collaborateur');
        })->where('archive', false)->get();
        
        $produits = Produit::where('archive', false)->get();
        
        return view('commande.add', compact('clients', 'collaborateurs', 'produits'));
    }

    public function store(Request $request)
    {
        $commande = Commande::create([
            'numero_commande' => Commande::genererNumero(),
            'nom_commande' => $request->nom_commande,
            'date_commande' => $request->date_commande,
            'duree_validite' => $request->duree_validite,
            'date_realisation_prevue' => $request->date_realisation_prevue,
            'statut' => 'en_cours',
            'type' => $request->type,
            'collaborateur_id' => $request->collaborateur_id,
            'client_prospect_id' => $request->client_prospect_id,
            'type_remise' => $request->type_remise,
            'remise' => $request->remise,
            'mode_paiement' => $request->mode_paiement
        ]);

        if($request->produits) {
            foreach($request->produits as $produit) {
                $commande->produits()->attach($produit['id'], [
                    'quantite' => $produit['quantite'],
                    'prix_unitaire' => $produit['prix_unitaire'],
                    'taux_tva' => $produit['taux_tva'],
                    'montant_ht' => $produit['montant_ht'],
                    'montant_tva' => $produit['montant_tva'],
                    'montant_ttc' => $produit['montant_ttc'],
                    'remise' => $produit['remise'] ?? 0,
                    'taux_remise' => $produit['taux_remise'] ?? 0
                ]);
            }
        }

        return redirect()->route('commande.index')->with('ok', 'Commande créée avec succès');
    }

    public function show($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        return view('commande.show', compact('commande'));
    }

    public function edit($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        $clients = Contact::whereHas('typecontacts', function($query) {
            $query->whereIn('type', ['Client', 'Prospect']);
        })->where('archive', false)->get();
        
        $collaborateurs = Contact::whereHas('typecontacts', function($query) {
            $query->where('type', 'Collaborateur');
        })->where('archive', false)->get();
        
        $produits = Produit::where('archive', false)->get();
        
        return view('commande.edit', compact('commande', 'clients', 'collaborateurs', 'produits'));
    }

    public function update(Request $request, $commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        
        $commande->update([
            'nom_commande' => $request->nom_commande,
            'date_commande' => $request->date_commande,
            'duree_validite' => $request->duree_validite,
            'date_realisation_prevue' => $request->date_realisation_prevue,
            'type' => $request->type,
            'collaborateur_id' => $request->collaborateur_id,
            'client_prospect_id' => $request->client_prospect_id,
            'type_remise' => $request->type_remise,
            'remise' => $request->remise,
            'mode_paiement' => $request->mode_paiement
        ]);

        // Mise à jour des produits
        $commande->produits()->detach();
        if($request->produits) {
            foreach($request->produits as $produit) {
                $commande->produits()->attach($produit['id'], [
                    'quantite' => $produit['quantite'],
                    'prix_unitaire' => $produit['prix_unitaire'],
                    'taux_tva' => $produit['taux_tva'],
                    'montant_ht' => $produit['montant_ht'],
                    'montant_tva' => $produit['montant_tva'],
                    'montant_ttc' => $produit['montant_ttc'],
                    'remise' => $produit['remise'] ?? 0,
                    'taux_remise' => $produit['taux_remise'] ?? 0
                ]);
            }
        }

        return redirect()->route('commande.index')->with('ok', 'Commande modifiée avec succès');
    }

    public function archiver($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        $commande->update(['archive' => true]);
        return redirect()->route('commande.index')->with('ok', 'Commande archivée avec succès');
    }

    public function desarchiver($commandeId)
    {
        $commande = Commande::findOrFail(Crypt::decrypt($commandeId));
        $commande->update(['archive' => false]);
        return redirect()->route('commande.archives')->with('ok', 'Commande désarchivée avec succès');
    }
}
