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
    Route::get('/caracteristique/detail/{caracteristiqueId}', 'show')->name('caracteristique.show')->middleware(['auth']);
    Route::get('/caracteristique/modifier/{caracteristiqueId}', 'edit')->name('caracteristique.edit')->middleware(['auth']);
    Route::post('/caracteristique/ajouter', 'store')->name('caracteristique.store')->middleware(['auth']);
    Route::post('/caracteristique/modifier/{caracteristiqueId}', 'update')->name('caracteristique.update')->middleware(['auth']);
    Route::post('/caracteristique/archiver/{caracteristiqueId}', 'archive')->name('caracteristique.archive')->middleware(['auth']);
    Route::post('/caracteristique/desarchiver/{caracteristiqueId}', 'unarchive')->name('caracteristique.unarchive')->middleware(['auth']);
    
    Route::post('/caracteristique-valeur/ajouter', 'store_valeur')->name('caracteristique_valeur.store')->middleware(['auth']);
    Route::post('/caracteristique-valeur/modifier/{valeur_caracteristiqueId}', 'update_valeur')->name('caracteristique_valeur.update')->middleware(['auth']);
    Route::post('/caracteristique-valeur/archiver/{valeur_caracteristiqueId}', 'archive_valeur')->name('caracteristique_valeur.archive')->middleware(['auth']);
    Route::post('/caracteristique-valeur/desarchiver/{valeur_caracteristiqueId}', 'unarchive_valeur')->name('caracteristique_valeur.unarchive')->middleware(['auth']);
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
    Route::post('/role/ajouter', 'store')->name('role.store')->middleware(['auth']);
    Route::post('/role/desarchiver/{roleId}', 'unarchive')->name('role.unarchive')->middleware(['auth']);
    Route::post('/role/modifier/{roleId}', 'update')->name('role.update')->middleware(['auth']);
    Route::put('/role/archiver/{roleId}', 'archive')->name('role.archive')->middleware(['auth']);
    Route::get('/role/permissions/{roleId}', 'permissions')->name('role.permissions')->middleware(['auth']);
    Route::post('/role/permissions/{roleId}', 'updatePermissions')->name('role.update_permissions')->middleware(['auth']);
});

// Permissions
Route::controller(PermissionController::class)->group(function () {
    Route::get('/permissions', 'index')->name('permission.index')->middleware(['auth']);
    Route::post('/permission/ajouter', 'store')->name('permission.store')->middleware(['auth']);
    Route::post('/permission/desarchiver/{roleId}', 'unarchive')->name('permission.unarchive')->middleware(['auth']);
    Route::post('/permission/modifier/{permission_id}', 'update')->name('permission.update')->middleware(['auth']);
    Route::post('/permission/modifier', 'updateRolePermission')->name('permission_role.update')->middleware(['auth']);
    Route::put('/permission/archiver/{roleId}', 'archive')->name('permission.archive')->middleware(['auth']);

});

// Contacts
Route::controller(ContactController::class)->group(function () {
    Route::get('/contacts', 'index')->name('contact.index')->middleware(['auth']);
    Route::get('/contacts/archives', 'archives')->name('contact.archives')->middleware(['auth']);
    Route::get('/contact/ajouter', 'create')->name('contact.create')->middleware(['auth']);
    Route::post('/contact/ajouter', 'store')->name('contact.store')->middleware(['auth']);
    Route::get('/contact/detail/{contactId}', 'show')->name('contact.show')->middleware(['auth']);
    Route::get('/contact/modifier/{contactId}', 'edit')->name('contact.edit')->middleware(['auth']);
    Route::post('/contact/modifier/{contactId}', 'update')->name('contact.update')->middleware(['auth']);
    Route::put('/contact/archiver/{contactId}', 'archiver')->name('contact.archive')->middleware(['auth']);
    Route::post('/contact/desarchiver/{contactId}', 'unarchive')->name('contact.unarchive')->middleware(['auth']);
    Route::post('/contact/associer/{entiteId}', 'associer_individu')->name('contact.associate')->middleware(['auth']);
    Route::post('/contact/desassocier/{entiteId}/{individuId}', 'deassocier_individu')->name('contact.deassociate')->middleware(['auth']);
});


// Utilisateurs
Route::controller(UtilisateurController::class)->group(function () {
    Route::get('/utilisateurs', 'index')->name('utilisateur.index')->middleware(['auth']);
    Route::get('/utilisateurs/archives', 'archives')->name('utilisateur.archives')->middleware(['auth']);
    Route::get('/utilisateur/ajouter', 'create')->name('utilisateur.create')->middleware(['auth']);
    Route::post('/utilisateur/ajouter', 'store')->name('utilisateur.store')->middleware(['auth']);
    Route::get('/utilisateur/detail/{utilisateurId}', 'show')->name('utilisateur.show')->middleware(['auth']);
    Route::post('/utilisateur/modifier/{utilisateurId}', 'update')->name('utilisateur.update')->middleware(['auth']);
    Route::put('/utilisateur/archiver/{utilisateurId}', 'archiver')->name('utilisateur.archive')->middleware(['auth']);
    Route::post('/utilisateur/desarchiver/{utilisateurId}', 'unarchive')->name('utilisateur.unarchive')->middleware(['auth']);
    Route::post('/utilisateur/associer/{entiteId}', 'associer_individu')->name('utilisateur.associate')->middleware(['auth']);
    Route::post('/utilisateur/desassocier/{entiteId}/{individuId}', 'deassocier_individu')->name('utilisateur.deassociate')->middleware(['auth']);
});

// Supprimer les routes d'archivage qui ne sont pas contacts

// Prospect
Route::controller(ProspectController::class)->group(function () {
    Route::get('/prospects', 'index')->name('prospect.index')->middleware(['auth']);
    Route::get('/prospects/archives', 'archives')->name('prospect.archives')->middleware(['auth']);
    Route::get('/prospect/ajouter', 'create')->name('prospect.create')->middleware(['auth']);
    Route::get('/prospect/modifier/{prospectId}', 'edit')->name('prospect.edit')->middleware(['auth']);
    Route::post('/prospect/ajouter', 'store')->name('prospect.store')->middleware(['auth']);
    Route::post('/prospect/modifier/{prospectId}', 'update')->name('prospect.update')->middleware(['auth']);
    Route::put('/prospect/archiver/{prospectId}', 'archive')->name('prospect.archive')->middleware(['auth']);
    Route::post('/prospect/desarchiver/{prospectId}', 'unarchive')->name('prospect.unarchive')->middleware(['auth']);
});

// Client
Route::controller(ClientController::class)->group(function () {
    Route::get('/clients', 'index')->name('client.index')->middleware(['auth']);
    Route::get('/clients/archives', 'archives')->name('client.archives')->middleware(['auth']);
    Route::post('/client/ajouter', 'store')->name('client.store')->middleware(['auth']);
    Route::get('/client/ajouter', 'create')->name('client.create')->middleware(['auth']);
    Route::get('/client/modifier/{clientId}', 'edit')->name('client.edit')->middleware(['auth']);
    Route::post('/client/modifier/{clientId}', 'update')->name('client.update')->middleware(['auth']);
    Route::put('/client/archiver/{clientId}', 'archive')->name('client.archive')->middleware(['auth']);
    Route::post('/client/desarchiver/{clientId}', 'unarchive')->name('client.unarchive')->middleware(['auth']);
});

// Collaborateurs
Route::controller(CollaborateurController::class)->group(function () {
    Route::get('/collaborateurs', 'index')->name('collaborateur.index')->middleware(['auth']);
    Route::get('/collaborateurs/archives', 'archives')->name('collaborateur.archives')->middleware(['auth']);
    Route::post('/collaborateur/ajouter', 'store')->name('collaborateur.store')->middleware(['auth']);
    Route::get('/collaborateur/ajouter', 'create')->name('collaborateur.create')->middleware(['auth']);
    Route::get('/collaborateur/modifier/{collaborateurId}', 'edit')->name('collaborateur.edit')->middleware(['auth']);
    Route::post('/collaborateur/modifier/{collaborateurId}', 'update')->name('collaborateur.update')->middleware(['auth']);
    Route::put('/collaborateur/archiver/{collaborateurId}', 'archive')->name('collaborateur.archive')->middleware(['auth']);
    Route::post('/collaborateur/desarchiver/{collaborateurId}', 'unarchive')->name('collaborateur.unarchive')->middleware(['auth']);
});


// Fournisseur
Route::controller(FournisseurController::class)->group(function () {
    Route::get('/fournisseurs', 'index')->name('fournisseur.index')->middleware(['auth']);
    Route::get('/fournisseurs/archives', 'archives')->name('fournisseur.archives')->middleware(['auth']);
    Route::post('/fournisseur/ajouter', 'store')->name('fournisseur.store')->middleware(['auth']);
    Route::get('/fournisseur/ajouter', 'create')->name('fournisseur.create')->middleware(['auth']);
    Route::get('/fournisseur/modifier/{fournisseurId}', 'edit')->name('fournisseur.edit')->middleware(['auth']);
    Route::post('/fournisseur/modifier/{fournisseurId}', 'update')->name('fournisseur.update')->middleware(['auth']);
    Route::put('/fournisseur/archiver/{fournisseurId}', 'archive')->name('fournisseur.archive')->middleware(['auth']);
    Route::post('/fournisseur/desarchiver/{fournisseurId}', 'unarchive')->name('fournisseur.unarchive')->middleware(['auth']);
});

// Agenda général
Route::controller(AgendaController::class)->group(function () {
    Route::get('/agendas/general', 'index')->name('agenda.index')->middleware(['auth']);
    Route::get('/agendas/general/listing', 'listing')->name('agenda.listing')->middleware(['auth']);
    Route::get('/agendas/general/listing-a-faire', 'listing_a_faire')->name('agenda.listing_a_faire')->middleware(['auth']);
    Route::get('/agendas/general/listing-en-retard', 'listing_en_retard')->name('agenda.listing_en_retard')->middleware(['auth']);
    Route::get('/agendas/general/listing-termine', 'listing_termine')->name('agenda.listing_termine')->middleware(['auth']);
    Route::post('/agenda/store', 'store')->name('agenda.store')->middleware(['auth']);
    Route::post('/agenda/update/{agenda_id}', 'update')->name('agenda.update')->middleware(['auth']);
    Route::put('/agenda/delete/{agenda_id}', 'destroy')->name('agenda.destroy')->middleware(['auth']);
});

// Produits
Route::controller(ProduitController::class)->group(function () {
    Route::get('/produits', 'index')->name('produit.index')->middleware(['auth']);
    Route::get('/produits/archives', 'archives')->name('produit.archives')->middleware(['auth']);
    Route::post('/produit/ajouter', 'store')->name('produit.store')->middleware(['auth']);
    Route::get('/produit/ajouter', 'create')->name('produit.create')->middleware(['auth']);
    Route::get('/produit/show/{produitId}', 'show')->name('produit.show')->middleware(['auth']);
    Route::get('/produit/modifier/{produitId}', 'edit')->name('produit.edit')->middleware(['auth']);
    Route::post('/produit/modifier/{produitId}', 'update')->name('produit.update')->middleware(['auth']);
    Route::put('/produit/archiver/{produitId}', 'archive')->name('produit.archive')->middleware(['auth']);
    Route::post('/produit/desarchiver/{produitId}', 'unarchive')->name('produit.unarchive')->middleware(['auth']);
    
    Route::post('/produit/images-create/{produitId}', 'uploadPhoto')->name('produit.uptof')->middleware(['auth']);
    Route::post('/produit/images-save/{produitId}', 'savePhoto')->name('produit.savetof')->middleware(['auth']);
    Route::get('/produit/images-delete/{produitId}', 'destroyPhoto')->name('produit.destroytof')->middleware(['auth']);
    Route::post('/produit/images-show/{produitId}', 'indexPhoto')->name('produit.indextof')->middleware(['auth']);
    Route::post('/produit/images-delete/{imageId}', 'deletePhoto')->name('produit.photoDelete')->middleware(['auth']);
    
    //Modifer les positions des photos du produit
    Route::post('/produit/images-update/{imageId}', 'updatePhoto')->name('produit.photoUpdate')->middleware(['auth']);
    // Télechargement d'une photo du produit
    Route::get('/produit/images-get/{imageId}', 'getPhoto')->name('produit.getPhoto')->middleware(['auth']);
    Route::get('/produit/fiche-technique-get/{nom_fichier}', 'getFicheTechnique')->name('produit.getFicheTechnique')->middleware(['auth']);
    
// Déclinaisons du produit

Route::post('/produit-declinaison/ajouter', 'store_declinaison')->name('produit_declinaison.store')->middleware(['auth']);
Route::post('/produit-declinaison/modifier/{produitId}', 'update_declinaison')->name('produit_declinaison.update')->middleware(['auth']);
Route::post('/produit-declinaison/archiver/{produitId}', 'archive_declinaison')->name('produit_declinaison.archive')->middleware(['auth']);
Route::post('/produit-declinaison/desarchiver/{produitId}', 'unarchive_declinaison')->name('produit_declinaison.unarchive')->middleware(['auth']);
    
});


require __DIR__ . '/auth.php';
