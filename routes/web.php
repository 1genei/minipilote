<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\Autho365Controller;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CollaborateurController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\TypecontactController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\CategorieproduitController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\CaracteristiqueController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DeviController;
use App\Http\Controllers\PrestationController;
use App\Http\Controllers\VoitureController;
use App\Http\Controllers\CircuitController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\ContactImportController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\ModelevoitureController;
use App\Http\Controllers\FactureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::view('/powergrid', 'powergrid-demo');

Route::get('/tests', [TestController::class, 'index'])->name('tests');
Route::get('/import-contact', [TestController::class, 'importContact'])->name('import_contact');
Route::get('/abb', [TestController::class, 'abb'])->name('abb');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//   Authentification office 365

Route::get('/login/o365', [Autho365Controller::class, 'login'])->name('logino365');
Route::get('/login/o365/callback', [Autho365Controller::class, 'redirect'])->name('redirecto365');

// Dashboard
Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('welcome')->middleware(['auth']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Paramètres
Route::controller(ParametreController::class)->group(function () {
    Route::get('/parametres', 'index')->name('parametre.index')->middleware(['auth']);
    Route::get('/parametres/contact', 'contact')->name('parametre.contact')->middleware(['auth']);
    Route::get('/parametres/produit', 'produit')->name('parametre.produit')->middleware(['auth']);
    Route::post('/parametres', 'update')->name('parametre.update')->middleware(['auth']);
});

// Societe
Route::controller(SocieteController::class)->group(function () {
    Route::post('/societe/ajouter', 'store')->name('societe.store')->middleware(['auth']);
    Route::post('/societe/modifier/{societeId}', 'update')->name('societe.update')->middleware(['auth']);
    Route::post('/societe/archiver/{societeId}', 'archive')->name('societe.archive')->middleware(['auth']);
    Route::post('/societe/desarchiver/{societeId}', 'unarchive')->name('societe.unarchive')->middleware(['auth']);
    Route::post('/societe/principale/{societeId}', 'setPrincipale')->name('societe.principale')->middleware(['auth']);
});

// Marque
Route::controller(MarqueController::class)->group(function () {
    Route::post('/marque/ajouter', 'store')->name('marque.store')->middleware(['auth']);
    Route::post('/marque/modifier/{marqueId}', 'update')->name('marque.update')->middleware(['auth']);
    Route::post('/marque/archiver/{marqueId}', 'archive')->name('marque.archive')->middleware(['auth']);
    Route::post('/marque/desarchiver/{marqueId}', 'unarchive')->name('marque.unarchive')->middleware(['auth']);
});

// Caracteristique
Route::controller(CaracteristiqueController::class)->group(function () {
    Route::get('/caracteristiques', 'index')->name('caracteristique.index')->middleware(['auth']);
    Route::get('/caracteristiques/archives', 'archives')->name('caracteristique.archives')->middleware(['auth']);
    Route::get('/caracteristiques/detail/{caracteristiqueId}', 'show')->name('caracteristique.show')->middleware(['auth']);
    Route::get('/caracteristiques/modifier/{caracteristiqueId}', 'edit')->name('caracteristique.edit')->middleware(['auth']);
    Route::post('/caracteristiques/ajouter', 'store')->name('caracteristique.store')->middleware(['auth']);
    Route::post('/caracteristiques/modifier/{caracteristiqueId}', 'update')->name('caracteristique.update')->middleware(['auth']);
    Route::post('/caracteristiques/archiver/{caracteristiqueId}', 'archive')->name('caracteristique.archive')->middleware(['auth']);
    Route::post('/caracteristiques/desarchiver/{caracteristiqueId}', 'unarchive')->name('caracteristique.unarchive')->middleware(['auth']);
    
    Route::post('/caracteristique-valeur/ajouter', 'store_valeur')->name('caracteristique_valeur.store')->middleware(['auth']);
    Route::post('/caracteristique-valeur/modifier/{valeur_caracteristiqueId}', 'update_valeur')->name('caracteristique_valeur.update')->middleware(['auth']);
    Route::post('/caracteristique-valeur/archiver/{valeur_caracteristiqueId}', 'archive_valeur')->name('caracteristique_valeur.archive')->middleware(['auth']);
    Route::post('/caracteristique-valeur/desarchiver/{valeur_caracteristiqueId}', 'unarchive_valeur')->name('caracteristique_valeur.unarchive')->middleware(['auth']);
});

// Voiture
Route::controller(VoitureController::class)->group(function () {
    Route::get('/voitures', 'index')->name('voiture.index')->middleware(['auth']);
    Route::get('/voitures/archives', 'archives')->name('voiture.archives')->middleware(['auth']);
    Route::get('/voitures/detail/{voitureId}', 'show')->name('voiture.show')->middleware(['auth']);
    Route::get('/voitures/modifier/{voitureId}', 'edit')->name('voiture.edit')->middleware(['auth']);
    Route::post('/voitures/ajouter', 'store')->name('voiture.store')->middleware(['auth']);
    Route::post('/voitures/modifier/{voitureId}', 'update')->name('voiture.update')->middleware(['auth']);
    Route::post('/voitures/archiver/{voitureId}', 'archiver')->name('voiture.archiver')->middleware(['auth']);
    Route::post('/voitures/desarchiver/{voitureId}', 'desarchiver')->name('voiture.desarchiver')->middleware(['auth']);
});

// Circuit
Route::controller(CircuitController::class)->group(function () {
    Route::get('/circuits', 'index')->name('circuit.index')->middleware(['auth']);
    Route::get('/circuits/archives', 'archives')->name('circuit.archives')->middleware(['auth']);
    Route::get('/circuits/detail/{circuitId}', 'show')->name('circuit.show')->middleware(['auth']);
    Route::get('/circuits/modifier/{circuitId}', 'edit')->name('circuit.edit')->middleware(['auth']);
    Route::post('/circuits/ajouter', 'store')->name('circuit.store')->middleware(['auth']);
    Route::post('/circuits/modifier/{circuitId}', 'update')->name('circuit.update')->middleware(['auth']);
    Route::post('/circuits/archiver/{circuitId}', 'archiver')->name('circuit.archiver')->middleware(['auth']);
    Route::post('/circuits/desarchiver/{circuitId}', 'desarchiver')->name('circuit.desarchiver')->middleware(['auth']);
});

// Planning
Route::controller(PlanningController::class)->group(function () {
    Route::get('/planning', 'index')->name('planning.index')->middleware(['auth']);
    Route::get('/planning/events', 'getEvents')->name('planning.events')->middleware(['auth']);
    
    // Routes pour les modèles de planning
    Route::get('/parametres/planning', 'indexModeles')->name('parametre.planning.index')->middleware(['auth']);
    Route::get('/parametres/planning/archives', 'indexArchives')->name('parametre.planning.archives')->middleware(['auth']);
    Route::post('/parametres/planning', 'store')->name('parametre.planning.store')->middleware(['auth']);
    Route::put('/parametres/planning/{planning}', 'update')->name('parametre.planning.update')->middleware(['auth']);
    Route::get('/parametres/planning/{planning}/archiver', 'archiver')->name('parametre.planning.archiver')->middleware(['auth']);
    Route::get('/parametres/planning/{planning}/restaurer', 'restaurer')->name('parametre.planning.restaurer')->middleware(['auth']);
});

// Categorieproduit
Route::controller(CategorieproduitController::class)->group(function () {
    Route::post('/categorieproduit/ajouter', 'store')->name('categorieproduit.store')->middleware(['auth']);
    Route::post('/categorieproduit/modifier/{categorieId}', 'update')->name('categorieproduit.update')->middleware(['auth']);
    Route::put('/categorieproduit/archiver/{categorieId}', 'archive')->name('categorieproduit.archive')->middleware(['auth']);
    Route::post('/categorieproduit/desarchiver/{categorieId}', 'unarchive')->name('categorieproduit.unarchive')->middleware(['auth']);
});

// Typecontacts
Route::controller(TypecontactController::class)->group(function () {
    Route::post('/typecontact/ajouter', 'store')->name('typecontact.store')->middleware(['auth']);
    Route::post('/typecontact/modifier/{typeId}', 'update')->name('typecontact.update')->middleware(['auth']);
    Route::put('/typecontact/archiver/{typeId}', 'archive')->name('typecontact.archive')->middleware(['auth']);
    Route::post('/typecontact/desarchiver/{typeId}', 'unarchive')->name('typecontact.unarchive')->middleware(['auth']);
});

// Postes
Route::controller(PosteController::class)->group(function () {
    Route::post('/poste/ajouter', 'store')->name('poste.store')->middleware(['auth']);
    Route::post('/poste/modifier/{posteId}', 'update')->name('poste.update')->middleware(['auth']);
    Route::put('/poste/archiver/{posteId}', 'archive')->name('poste.archive')->middleware(['auth']);
    Route::post('/poste/desarchiver/{posteId}', 'unarchive')->name('poste.unarchive')->middleware(['auth']);
});

// Rôles
Route::controller(RoleController::class)->group(function () {
    Route::get('/roles', 'index')->name('role.index')->middleware(['auth']);
    Route::post('/roles/ajouter', 'store')->name('role.store')->middleware(['auth']);
    Route::post('/roles/desarchiver/{roleId}', 'unarchive')->name('role.unarchive')->middleware(['auth']);
    Route::post('/roles/modifier/{roleId}', 'update')->name('role.update')->middleware(['auth']);
    Route::put('/roles/archiver/{roleId}', 'archive')->name('role.archive')->middleware(['auth']);
    Route::get('/roles/permissions/{roleId}', 'permissions')->name('role.permissions')->middleware(['auth']);
    Route::post('/roles/permissions/{roleId}', 'updatePermissions')->name('role.update_permissions')->middleware(['auth']);
});

// Permissions
Route::controller(PermissionController::class)->group(function () {
    Route::get('/permissions', 'index')->name('permission.index')->middleware(['auth']);
    Route::post('/permissions/ajouter/', 'store')->name('permission.store')->middleware(['auth']);
    Route::post('/permissions/ajouter-auto', 'storeAuto')->name('permission.store_auto')->middleware(['auth']);
    Route::post('/permissions/desarchiver/{roleId}', 'unarchive')->name('permission.unarchive')->middleware(['auth']);
    Route::post('/permissions/modifier/{permission_id}', 'update')->name('permission.update')->middleware(['auth']);
    Route::post('/permissions/modifier', 'updateRolePermission')->name('permission_role.update')->middleware(['auth']);
    Route::put('/permissions/archiver/{roleId}', 'archive')->name('permission.archive')->middleware(['auth']);

});

// Contacts
Route::controller(ContactController::class)->group(function () {
    Route::get('/contacts', 'index')->name('contact.index')->middleware(['auth']);
    Route::get('/contacts/archives', 'archives')->name('contact.archives')->middleware(['auth']);
    Route::get('/contacts/ajouter', 'create')->name('contact.create')->middleware(['auth']);
    Route::post('/contacts/ajouter', 'store')->name('contact.store')->middleware(['auth']);
    Route::get('/contacts/detail/{contactId}', 'show')->name('contact.show')->middleware(['auth']);
    Route::get('/contacts/modifier/{contactId}', 'edit')->name('contact.edit')->middleware(['auth']);
    Route::post('/contacts/modifier/{contactId}', 'update')->name('contact.update')->middleware(['auth']);
    Route::put('/contacts/archiver/{contactId}', 'archiver')->name('contact.archive')->middleware(['auth']);
    Route::post('/contacts/desarchiver/{contactId}', 'unarchive')->name('contact.unarchive')->middleware(['auth']);
    Route::post('/contacts/associer/{entiteId}', 'associer_individu')->name('contact.associate')->middleware(['auth']);
    Route::post('/contacts/desassocier/{entiteId}/{individuId}', 'dissocier_individu')->name('contact.deassociate')->middleware(['auth']);
});


// Utilisateurs
Route::controller(UtilisateurController::class)->group(function () {
    Route::get('/utilisateurs', 'index')->name('utilisateur.index')->middleware(['auth']);
    Route::get('/utilisateurs/archives', 'archives')->name('utilisateur.archives')->middleware(['auth']);
    Route::get('/utilisateurs/ajouter', 'create')->name('utilisateur.create')->middleware(['auth']);
    Route::post('/utilisateurs/ajouter', 'store')->name('utilisateur.store')->middleware(['auth']);
    Route::get('/utilisateurs/detail/{utilisateurId}', 'show')->name('utilisateur.show')->middleware(['auth']);
    Route::get('/utilisateurs/modifier/{utilisateurId}', 'edit')->name('utilisateur.edit')->middleware(['auth']);
    Route::post('/utilisateurs/modifier/{utilisateurId}', 'update')->name('utilisateur.update')->middleware(['auth']);
    Route::put('/utilisateurs/archiver/{utilisateurId}', 'archiver')->name('utilisateur.archive')->middleware(['auth']);
    Route::post('/utilisateurs/desarchiver/{utilisateurId}', 'unarchive')->name('utilisateur.unarchive')->middleware(['auth']);
    Route::post('/utilisateurs/associer/{entiteId}', 'associer_individu')->name('utilisateur.associate')->middleware(['auth']);
    Route::post('/utilisateurs/desassocier/{entiteId}/{individuId}', 'dissocier_individu')->name('utilisateur.deassociate')->middleware(['auth']);
});

// Supprimer les routes d'archivage qui ne sont pas contacts

// Prospect
Route::controller(ProspectController::class)->group(function () {
    Route::get('/prospects', 'index')->name('prospect.index')->middleware(['auth']);
    Route::get('/prospects/archives', 'archives')->name('prospect.archives')->middleware(['auth']);
    Route::get('/prospects/ajouter', 'create')->name('prospect.create')->middleware(['auth']);
    Route::get('/prospects/modifier/{prospectId}', 'edit')->name('prospect.edit')->middleware(['auth']);
    Route::post('/prospects/ajouter', 'store')->name('prospect.store')->middleware(['auth']);
    Route::post('/prospects/modifier/{prospectId}', 'update')->name('prospect.update')->middleware(['auth']);
    Route::put('/prospects/archiver/{prospectId}', 'archive')->name('prospect.archive')->middleware(['auth']);
    Route::post('/prospects/desarchiver/{prospectId}', 'unarchive')->name('prospect.unarchive')->middleware(['auth']);
});

// Client
Route::controller(ClientController::class)->group(function () {
    Route::get('/clients', 'index')->name('client.index')->middleware(['auth']);
    Route::get('/clients/archives', 'archives')->name('client.archives')->middleware(['auth']);
    Route::post('/clients/ajouter', 'store')->name('client.store')->middleware(['auth']);
    Route::get('/clients/ajouter', 'create')->name('client.create')->middleware(['auth']);
    Route::get('/clients/modifier/{clientId}', 'edit')->name('client.edit')->middleware(['auth']);
    Route::post('/clients/modifier/{clientId}', 'update')->name('client.update')->middleware(['auth']);
    Route::put('/clients/archiver/{clientId}', 'archive')->name('client.archive')->middleware(['auth']);
    Route::post('/clients/desarchiver/{clientId}', 'unarchive')->name('client.unarchive')->middleware(['auth']);
});

// Collaborateurs
Route::controller(CollaborateurController::class)->group(function () {
    Route::get('/collaborateurs', 'index')->name('collaborateur.index')->middleware(['auth']);
    Route::get('/collaborateurs/archives', 'archives')->name('collaborateur.archives')->middleware(['auth']);
    Route::post('/collaborateurs/ajouter', 'store')->name('collaborateur.store')->middleware(['auth']);
    Route::get('/collaborateurs/ajouter', 'create')->name('collaborateur.create')->middleware(['auth']);
    Route::get('/collaborateurs/modifier/{collaborateurId}', 'edit')->name('collaborateur.edit')->middleware(['auth']);
    Route::post('/collaborateurs/modifier/{collaborateurId}', 'update')->name('collaborateur.update')->middleware(['auth']);
    Route::put('/collaborateurs/archiver/{collaborateurId}', 'archive')->name('collaborateur.archive')->middleware(['auth']);
    Route::post('/collaborateurs/desarchiver/{collaborateurId}', 'unarchive')->name('collaborateur.unarchive')->middleware(['auth']);
});


// Fournisseur
Route::controller(FournisseurController::class)->group(function () {
    Route::get('/fournisseurs', 'index')->name('fournisseur.index')->middleware(['auth']);
    Route::get('/fournisseurs/archives', 'archives')->name('fournisseur.archives')->middleware(['auth']);
    Route::post('/fournisseurs/ajouter', 'store')->name('fournisseur.store')->middleware(['auth']);
    Route::get('/fournisseurs/ajouter', 'create')->name('fournisseur.create')->middleware(['auth']);
    Route::get('/fournisseurs/modifier/{fournisseurId}', 'edit')->name('fournisseur.edit')->middleware(['auth']);
    Route::post('/fournisseurs/modifier/{fournisseurId}', 'update')->name('fournisseur.update')->middleware(['auth']);
    Route::put('/fournisseurs/archiver/{fournisseurId}', 'archive')->name('fournisseur.archive')->middleware(['auth']);
    Route::post('/fournisseurs/desarchiver/{fournisseurId}', 'unarchive')->name('fournisseur.unarchive')->middleware(['auth']);
});

// Agenda général
Route::controller(AgendaController::class)->group(function () {
    Route::get('/agendas/general', 'index')->name('agenda.index')->middleware(['auth']);
    Route::get('/agendas/general/listing', 'listing')->name('agenda.listing')->middleware(['auth']);
    Route::get('/agendas/general/listing-a-faire', 'listing_a_faire')->name('agenda.listing_a_faire')->middleware(['auth']);
    Route::get('/agendas/general/listing-en-retard', 'listing_en_retard')->name('agenda.listing_en_retard')->middleware(['auth']);
    Route::get('/agendas/general/listing-termine', 'listing_termine')->name('agenda.listing_termine')->middleware(['auth']);
    Route::post('/agendas/store', 'store')->name('agenda.store')->middleware(['auth']);
    Route::post('/agendas/update/{agenda_id}', 'update')->name('agenda.update')->middleware(['auth']);
    Route::put('/agendas/delete/{agenda_id}', 'destroy')->name('agenda.destroy')->middleware(['auth']);
});

// Produits
Route::controller(ProduitController::class)->group(function () {
    Route::get('/produits', 'index')->name('produit.index')->middleware(['auth']);
    Route::get('/produits/archives', 'archives')->name('produit.archives')->middleware(['auth']);
    Route::post('/produits/ajouter', 'store')->name('produit.store')->middleware(['auth']);
    Route::get('/produits/ajouter', 'create')->name('produit.create')->middleware(['auth']);
    Route::get('/produits/show/{produitId}', 'show')->name('produit.show')->middleware(['auth']);
    Route::get('/produits/modifier/{produitId}', 'edit')->name('produit.edit')->middleware(['auth']);
    Route::post('/produits/modifier/{produitId}', 'update')->name('produit.update')->middleware(['auth']);
    Route::put('/produits/archiver/{produitId}', 'archiver')->name('produit.archive')->middleware(['auth']);
    Route::post('/produits/desarchiver/{produitId}', 'desarchiver')->name('produit.unarchive')->middleware(['auth']);
    Route::get('/produits/rechercher', 'rechercher_produit')->name('produit.rechercher')->middleware(['auth']);
    
    Route::post('/produit/images-create/{produitId}', 'uploadPhoto')->name('produit.uptof')->middleware(['auth']);
    Route::post('/produit/images-save/{produitId}', 'savePhoto')->name('produit.savetof')->middleware(['auth']);
    Route::get('/produit/images-delete/{produitId}', 'destroyPhoto')->name('produit.destroytof')->middleware(['auth']);
    Route::post('/produit/images-show/{produitId}', 'indexPhoto')->name('produit.indextof')->middleware(['auth']);
    Route::post('/produit/images-delete/{imageId}', 'deletePhoto')->name('produit.photoDelete')->middleware(['auth']);
    
    //Modifer les positions des photos du produit
    Route::post('/produit/images-update/{imageId}', 'updatePhoto')->name('produit.photoUpdate')->middleware(['auth']);
    // Télechargement d'une photo du produit
    Route::get('/produits/images-get/{imageId}', 'getPhoto')->name('produit.getPhoto')->middleware(['auth']);
    Route::get('/produits/fiche-technique-get/{nom_fichier}', 'getFicheTechnique')->name('produit.getFicheTechnique')->middleware(['auth']);
    
    // Déclinaisons du produit
    Route::post('/produit-declinaison/ajouter', 'store_declinaison')->name('produit_declinaison.store')->middleware(['auth']);
    Route::post('/produit-declinaison/modifier/{produitId}', 'update_declinaison')->name('produit_declinaison.update')->middleware(['auth']);
    Route::get('/produit-declinaison/recalculer/{produitParentId}', 'recalculer_declinaisons')->name('produit_declinaison.recalculer')->middleware(['auth']);
    Route::post('/produit-declinaison-all/modifier/{produitId}', 'update_all_declinaison')->name('produit_all_declinaison.update')->middleware(['auth']);
    Route::post('/produit-declinaison/archiver/{produitId}', 'archive_declinaison')->name('produit_declinaison.archive')->middleware(['auth']);
    Route::post('/produit-declinaison/desarchiver/{produitId}', 'unarchive_declinaison')->name('produit_declinaison.unarchive')->middleware(['auth']);
    
});


// Contrats
Route::controller(ContratController::class)->group(function () {
    Route::get('/contrats', 'index')->name('contrat.index')->middleware(['auth']);
    Route::get('/contrats/archives', 'archives')->name('contrat.archives')->middleware(['auth']);
    Route::post('/contrats/ajouter', 'store')->name('contrat.store')->middleware(['auth']);
    Route::get('/contrats/ajouter', 'create')->name('contrat.create')->middleware(['auth']);
    Route::get('/contrats/modifier/{contratId}', 'edit')->name('contrat.edit')->middleware(['auth']);
    Route::post('/contrats/modifier/{contratId}', 'update')->name('contrat.update')->middleware(['auth']);
    Route::put('/contrats/archiver/{contratId}', 'archive')->name('contrat.archive')->middleware(['auth']);
    Route::post('/contrats/desarchiver/{contratId}', 'unarchive')->name('contrat.unarchive')->middleware(['auth']);
});


// Devis
Route::controller(DeviController::class)->group(function () {
    Route::get('/devis', 'index')->name('devis.index')->middleware(['auth']);
    Route::get('/devis/archives', 'archives')->name('devis.archives')->middleware(['auth']);
    Route::get('/devis/create', 'create')->name('devis.create')->middleware(['auth']);
    Route::get('/devis/detail/{deviId}', 'show')->name('devis.show')->middleware(['auth']);
    Route::get('/devis/modifier/{deviId}', 'edit')->name('devis.edit')->middleware(['auth']);
    Route::get('/devis/telecharger/{deviId}', 'telecharger')->name('devis.telecharger');    
    Route::post('/devis/envoyer_mail/{deviId}', 'envoyer_mail')->name('devis.envoyer_mail')->middleware(['auth']);    
    Route::post('/devis/ajouter', 'store')->name('devis.store')->middleware(['auth']);
    Route::post('/devis/modifier/{deviId}', 'update')->name('devis.update')->middleware(['auth']);
    Route::post('/devis/modifier-statut/{devis}/{statut}', 'modifierStatut')->name('devis.updateStatut')->middleware(['auth']);
    Route::post('/devis/archiver/{deviId}', 'archiver')->name('devis.archiver')->middleware(['auth']);
    Route::post('/devis/desarchiver/{deviId}', 'desarchiver')->name('devis.desarchiver')->middleware(['auth']);
});

// Routes pour les commandes
Route::middleware(['auth'])->group(function () {
    Route::prefix('commandes')->group(function () {
        Route::get('/', [CommandeController::class, 'index'])->name('commande.index');
        Route::get('/archives', [CommandeController::class, 'archives'])->name('commande.archives');
        Route::get('/create', [CommandeController::class, 'create'])->name('commande.create');
        Route::post('/store', [CommandeController::class, 'store'])->name('commande.store');
        Route::get('/{commande}/show', [CommandeController::class, 'show'])->name('commande.show');
        Route::get('/{commande}/edit', [CommandeController::class, 'edit'])->name('commande.edit');
        Route::post('/{commande}/update', [CommandeController::class, 'update'])->name('commande.update');
        Route::post('/{commande}/archiver', [CommandeController::class, 'archiver'])->name('commande.archiver');
        Route::post('/{commande}/desarchiver', [CommandeController::class, 'desarchiver'])->name('commande.desarchiver');       
        Route::post('/{commande}/envoyer-mail', [CommandeController::class, 'envoyer_mail'])->name('commande.envoyer_mail');
    });
});
Route::get('/commandes/telecharger/{commandeId}', [CommandeController::class, 'telecharger'])->name('commande.telecharger');


// Prestations
Route::controller(PrestationController::class)->group(function () {
    Route::get('/prestations', 'index')->name('prestation.index')->middleware(['auth']);
    Route::get('/prestations/archives', 'archives')->name('prestation.archives')->middleware(['auth']);
    Route::post('/prestations/ajouter', 'store')->name('prestation.store')->middleware(['auth']);
    Route::get('/prestations/ajouter/{evenement_id?}', 'create')->name('prestation.create')->middleware(['auth']);
    Route::get('/prestations/modifier/{prestationId}/{evenement_id?}', 'edit')->name('prestation.edit')->middleware(['auth']);
    Route::post('/prestations/modifier/{prestationId}', 'update')->name('prestation.update')->middleware(['auth']);
    Route::put('/prestations/archiver/{prestationId}', 'archive')->name('prestation.archive')->middleware(['auth']);
    Route::put('/prestations/desarchiver/{prestationId}', 'unarchive')->name('prestation.unarchive')->middleware(['auth']);
});

// Evenements
Route::controller(EvenementController::class)->group(function () {
    Route::get('/evenements', 'index')->name('evenement.index')->middleware(['auth']);
    Route::get('/evenements/archives', 'archives')->name('evenement.archives')->middleware(['auth']);
    Route::post('/evenements/ajouter', 'store')->name('evenement.store')->middleware(['auth']);
    Route::get('/evenements/ajouter', 'create')->name('evenement.create')->middleware(['auth']);
    Route::get('/evenements/modifier/{evenementId}', 'edit')->name('evenement.edit')->middleware(['auth']);
    Route::get('/evenements/details/{evenementId}', 'show')->name('evenement.show')->middleware(['auth']);
    Route::post('/evenements/modifier/{evenementId}', 'update')->name('evenement.update')->middleware(['auth']);
    Route::put('/evenements/archiver/{evenementId}', 'archive')->name('evenement.archive')->middleware(['auth']);
    Route::put('/evenements/desarchiver/{evenementId}', 'unarchive')->name('evenement.unarchive')->middleware(['auth']);
});

// Dépenses
Route::controller(DepenseController::class)->group(function () {
    Route::get('/depenses', 'index')->name('depense.index')->middleware(['auth']);
    Route::get('/depenses/archives', 'archives')->name('depense.archives')->middleware(['auth']);
    Route::post('/depenses/ajouter', 'store')->name('depense.store')->middleware(['auth']);
    Route::get('/depenses/ajouter', 'create')->name('depense.create')->middleware(['auth']);
    Route::get('/depenses/modifier/{depenseId}', 'edit')->name('depense.edit')->middleware(['auth']);
    Route::get('/depenses/details/{depenseId}', 'show')->name('depense.show')->middleware(['auth']);
    Route::post('/depenses/modifier/{depenseId}', 'update')->name('depense.update')->middleware(['auth']);
    Route::put('/depenses/archiver/{depenseId}', 'archive')->name('depense.archive')->middleware(['auth']);
    Route::put('/depenses/desarchiver/{depenseId}', 'unarchive')->name('depense.unarchive')->middleware(['auth']);
});

Route::post('/utilisateur/{user}/update-password', [UtilisateurController::class, 'updatePassword'])
    ->name('utilisateur.update-password');

Route::middleware(['auth'])->group(function () {
    Route::get('/contacts/import', [ContactImportController::class, 'showImportForm'])->name('contact.import');
    Route::post('/contacts/import', [ContactImportController::class, 'processImport'])->name('contact.import.process');
    Route::get('/contacts/search/entite', [ContactController::class, 'searchEntite'])
        ->name('contact.search.entite');
    Route::get('/contacts/search/all', [ContactController::class, 'searchAllContacts'])
        ->name('contact.search.all');
});

Route::get('/contacts/search/individu', [ContactController::class, 'searchIndividu'])
    ->name('contact.search.individu')
    ->middleware('auth');

Route::post('/contacts/quick-add', [ContactController::class, 'quickAdd'])
    ->name('contact.quick-add')
    ->middleware('auth');

// Routes pour la création de commande à partir d'un devis
Route::get('/commande/createfromdevis/{devis_id}', [CommandeController::class, 'createfromdevis'])->name('commande.createfromdevis');
Route::post('/commande/storefromdevis/{devis_id}', [CommandeController::class, 'storefromdevis'])->name('commande.storefromdevis');

// Routes pour le planning
Route::prefix('planning')->group(function () {
    Route::get('/', [PlanningController::class, 'index'])->name('planning.index');
    Route::get('/events', [PlanningController::class, 'getEvents'])->name('planning.events');
});

// Routes pour les modèles de voiture
Route::post('/modelevoiture/store', [ModelevoitureController::class, 'store'])->name('modelevoiture.store');
Route::post('/modelevoiture/update/{id}', [ModelevoitureController::class, 'update'])->name('modelevoiture.update');
Route::delete('/modelevoiture/destroy/{id}', [ModelevoitureController::class, 'destroy'])->name('modelevoiture.destroy');

// Factures
Route::controller(FactureController::class)->group(function () {
    Route::get('/factures', 'index')->name('facture.index')->middleware(['auth']);
    Route::get('/factures/archives', 'archives')->name('facture.archives')->middleware(['auth']);
    Route::get('/factures/create', 'create')->name('facture.create')->middleware(['auth']);
    Route::post('/factures/store', 'store')->name('facture.store')->middleware(['auth']);
    Route::post('/factures/preview', 'previewPDF')->name('facture.preview')->middleware(['auth']);
    Route::get('/factures/preview/show', 'showPreview')->name('facture.preview.show')->middleware(['auth']);
    Route::post('/factures/preview/validate', 'validatePreview')->name('facture.preview.validate')->middleware(['auth']);
    Route::get('/factures/{facture}/show', 'show')->name('facture.show')->middleware(['auth']);
    Route::post('/factures/{facture}/update', 'update')->name('facture.update')->middleware(['auth']);
    Route::put('/factures/{facture}/archive', 'archive')->name('facture.archive')->middleware(['auth']);
    Route::post('/factures/{facture}/restore', 'restore')->name('facture.restore')->middleware(['auth']);
    Route::delete('/factures/{facture}/destroy', 'destroy')->name('facture.destroy')->middleware(['auth']);
    
    // Routes spéciales
    Route::get('/factures/create-from-commande/{commandeId}', 'createFromCommande')->name('facture.create-from-commande')->middleware(['auth']);
    // Route::post('/factures/create-multiple', 'createMultiple')->name('facture.create-multiple')->middleware(['auth']);
    Route::post('/factures/{facture}/marquer-payee', 'marquerPayee')->name('facture.marquer-payee')->middleware(['auth']);
    Route::get('/factures/{facture}/pdf', 'generatePDF')->name('facture.pdf')->middleware(['auth']);
    
    // API routes
    Route::get('/api/factures/commandes-non-facturees/{clientId}', 'getCommandesNonFacturees')->name('facture.api.commandes-non-facturees')->middleware(['auth']);
});

require __DIR__ . '/auth.php';
