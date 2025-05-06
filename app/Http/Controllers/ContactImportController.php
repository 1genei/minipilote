<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Entite;
use App\Models\Individu;
use App\Models\SecteurActivite;
use App\Models\Tag;
use App\Models\Typecontact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContactImportController extends Controller
{
    public function showImportForm()
    {
        return view('contact.import');
    }

    public function processImport(Request $request)
    {
        // $request->validate([
        //     'csv_file' => 'required|file|mimes:csv,txt'
        // ]);

        try {
            DB::beginTransaction();

            // Récupérer ou créer le tag digisolus
            $tagDigisolus = Tag::firstOrCreate(
                ['nom' => 'digisolus'],
                ['archive' => false]
            );

            dd($request->file('csv_file')->getPathname());

            $handle = fopen($request->file('csv_file')->getPathname(), 'r');
            // Définir le séparateur comme point-virgule
            $header = str_getcsv(fgets($handle), ';'); 
            $importCount = 0;

            while (($line = fgets($handle)) !== false) {
                $record = str_getcsv($line, ';');
                $data = array_combine($header, $record);
                // dd($data);
                // vérifier si le nom et le prénom est vide
                if (empty($data['nom']) && empty($data['prenom'])) {
                    continue;
                }
                // Créer ou récupérer le secteur d'activité
                $secteurActivite = SecteurActivite::firstOrCreate(
                    ['nom' => $data['secteur dactivite']],
                    ['archive' => false]
                );
                // Créer le contact
                $contact = Contact::create([
                    'user_id' => Auth::id(),
                    'type' => 'individu',
                    'nature' => 'Personne physique',
                    'commercial_id' => Auth::id(),
                    "source_contact" => 'digisolus',
                    'secteur_activite_id' => $secteurActivite->id
                ]);

                $typecontact = Typecontact::where('type', "Prospect")->first();
                $contact->typeContacts()->attach($typecontact->id);
                
                // Ajouter le tag digisolus
                $contact->tags()->attach($tagDigisolus->id);

                // Créer l'individu associé
                $individu = Individu::create([
                    'contact_id' => $contact->id,
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'email' => $data['email'],
                    'linkedin' => $data['linkedin'],
                    'entreprise' => $data['entreprise'],
                    'fonction_entreprise' => $data['fonction'],
                    'effectif_entreprise' => $data['nombre employe'],
                    'site_web_entreprise' => $data['site web entreprise'],
                    'telephone_mobile' => $data['telephone'],
                    'region' => $data['region'],
                    'ville' => $data['ville'],
                    'pays' => $data['pays']
                ]);
                
                // dd($individu, $contact);
                $importCount++;
            }

            fclose($handle);
            DB::commit();

            return redirect()->route('contact.import')
                ->with('success', "Import réussi ! $importCount contacts ont été importés.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('contact.import')
                ->withErrors(['error' => 'Une erreur est survenue lors de l\'import : ' . $e->getMessage()]);
        }
    }
} 