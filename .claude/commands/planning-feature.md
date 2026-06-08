Tu travailles sur le module Planning de Minipilote.

Modèles concernés : Planning, Agenda, Prestation, Commande
Table Livewire : `app/Http/Livewire/Planning/IndexTable.php`

Contexte métier :
- Une Prestation est liée à une Commande et placée dans un Planning
- Pilotage = tours en conduite autonome
- BP (Baptême Pilotage) = tours passager
- CAM = présence d'une caméra (auto-coché si produit "Caméra" dans la commande)
- P (Permis) = le bénéficiaire a son permis de conduire
- D (Décharge) = décharge signée

Tâche : $ARGUMENTS