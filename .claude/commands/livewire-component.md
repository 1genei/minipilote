Crée un composant Livewire 2 pour Minipilote.

Règles :
- Namespace : `App\Http\Livewire\{Domaine}\`
- Vérifier les permissions avec `Gate::allows()` dans `mount()`
- Utiliser `$this->dispatchBrowserEvent()` pour les notifications
- Toujours typehinter les propriétés publiques
- IDs chiffrés dans tous les liens/routes

Vue Blade associée dans `resources/views/livewire/{domaine}/`

Arguments : $ARGUMENTS