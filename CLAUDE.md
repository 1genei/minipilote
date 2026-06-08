# CLAUDE.md

Ce fichier fournit des instructions à Claude Code (claude.ai/code) pour travailler dans ce dépôt.

## Présentation du projet

**Minipilote** est un CRM/ERP Laravel 10 pour une société de pilotage automobile. Il gère les contacts, produits, événements (journées circuit), véhicules, planning, devis, commandes, factures, contrats et dépenses. L'interface et tout le code sont en **français**.

## Commandes de développement

```bash
# Lancer le serveur frontend (Vite + Tailwind)
npm run dev

# Compiler les assets pour la production
npm run build

# Lancer les migrations
php artisan migrate

# Réinitialiser la BDD (local uniquement)
php artisan migrate:fresh --seed

# Vider les caches (si vues/routes ne se mettent pas à jour)
php artisan cache:clear && php artisan view:clear && php artisan route:clear && php artisan config:clear

# Créer le lien symbolique storage
php artisan storage:link

# Débogage interactif
php artisan tinker
```

L'application tourne via XAMPP (Apache + MySQL). Pas de suite de tests active.

## Stack

- **Laravel 10** (PHP 8.1+), **Livewire 2**, **PowerGrid 4** (tableaux de données), **Tailwind CSS 3** + **Alpine.js 3**
- **DomPDF** (`barryvdh/laravel-dompdf`) — génération PDF
- **Intervention Image** — gestion des images produits
- **OpenSpout** — import/export Excel/CSV
- **Microsoft O365 OAuth** via `Autho365Controller`
- Base de données : MySQL via XAMPP, base `minipilote`, utilisateur `root` sans mot de passe

## Méthode de travail

**Toujours suivre l'ordre : Explorer → Planifier → Implémenter**

Avant de coder, explorer les fichiers concernés et expliquer ce qui va être touché (fichiers, méthodes, tables) avant de commencer la moindre modification.

## Règles absolues

1. **IDs chiffrés** : TOUJOURS `Crypt::encrypt()` en sortie, `Crypt::decrypt()` en entrée dans les URLs — ne jamais exposer un ID brut
2. **Langue** : tout le code, commentaires, variables métier, messages utilisateur = FRANÇAIS
3. **Contacts polymorphes** : passer par `$contact->infos()`, jamais d'accès direct à `->individu` ou `->entite` sans vérifier le type
4. **Archivage dual** : SoftDeletes (`Facture`, `Prestation`) vs champ booléen `archive` (`Contact`, `Produit`)
5. **Permissions** : `@can('permission', 'nom')` en Blade, `Gate::allows('permission', 'nom')` en PHP
6. **Migrations** : ne jamais modifier une migration existante — toujours créer une nouvelle migration
7. **Débogage** : ne jamais laisser `dd()` en dehors du développement local

## Patterns d'architecture

### Chiffrement des IDs dans les routes

```php
// Dans le contrôleur, en sortie
return redirect()->route('facture.show', Crypt::encrypt($facture->id));

// Dans le contrôleur, en réception
$facture = Facture::findOrFail(Crypt::decrypt($id));
```

### Polymorphisme Contact

`Contact` est l'entité de base pour toutes les personnes/sociétés. Le champ `type` vaut `"individu"` ou `"entite"` et délègue vers `Individu` (nom, prenom, email…) ou `Entite` (raison_sociale…). Le même `Contact` est réutilisé comme client, fournisseur, prospect, collaborateur — ce sont des classifications, pas des entités séparées.

```php
$contact->infos(); // retourne l'Individu ou l'Entite selon le type
```

### Flux documents

```
Devi → (validé) → Commande → (facturé) → Facture
```

- `Facture` : champ `palier` (cast array) pour les paiements échelonnés, `paiements` (cast array) pour le suivi des règlements
- Numérotation factures clients : commence à 1500 (`Facture::getProchainNumeroFactureClient()`)

### Génération PDF

```php
$societePrincipale = Societe::where('est_societe_principale', true)->first();

PDF::loadView('facture.pdf', compact('facture', 'societePrincipale'))->setPaper('A4');
```

- PDFs finaux stockés dans `storage/app/public/factures/` (ou `devis/`, `commandes/`)
- PDFs de prévisualisation temporaires dans `storage/app/public/temp/`
- Servir via `asset('storage/...')`
- Toujours passer `$societePrincipale` aux vues PDF

### Tableaux Livewire PowerGrid

```
app/Http/Livewire/{Domaine}/IndexTable.php   ← tableau principal
app/Http/Livewire/{Domaine}/ArchiveTable.php ← tableau archives
```

- Datasource : requête Eloquent dans `datasource()`
- Colonnes avec HTML : toujours échapper avec `e($valeur)`
- Boutons d'action : `Crypt::encrypt($model->id)` dans les routes

### Nommage des permissions

`afficher-xxx` · `ajouter-xxx` · `modifier-xxx` · `supprimer-xxx`

## Modèles par domaine

| Domaine | Modèles principaux |
|---------|-------------------|
| Contacts | `Contact`, `Individu`, `Entite` |
| Motorsport | `Voiture`, `Modelevoiture`, `Circuit`, `Evenement` |
| Planning | `Planning`, `Agenda`, `Prestation` |
| Produits | `Produit`, `Categorieproduit`, `Marque`, `Caracteristique`, `Valeurcaracteristique`, `Stock` |
| Documents | `Devi`, `Commande`, `Facture`, `Contrat` |
| Finance | `Depense`, `Tva` |
| Utilisateurs | `User`, `Role`, `Permission` |

## Conventions de nommage des fichiers

- Contrôleurs : `{Domaine}Controller.php` dans `app/Http/Controllers/`
- Composants Livewire : `app/Http/Livewire/{Domaine}/{NomComposant}.php`
- Vues Livewire : `resources/views/livewire/{domaine}/{nom-composant}.blade.php`
- Vues standard : `resources/views/{domaine}/{index|show|add|edit|archives}.blade.php`
- Modèles : `protected $guarded = []` (masse-assignation ouverte)

## Fonctions utilitaires (`app/helpers.php`)

- `decode_string($json)` — convertit un tableau JSON en chaîne affichable avec séparateur ` - `
- `string_to_date($string, $lang='fr')` — formate une date en `d/m/Y` (fr) ou `Y-m-d` (en)
