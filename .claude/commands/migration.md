Crée une migration Laravel pour le projet Minipilote.

Règles :
- Nom de fichier : `YYYY_MM_DD_HHMMSS_description_en_francais.php`
- Toujours ajouter `->comment('description')` sur les colonnes importantes
- Clés étrangères avec `constrained()->cascadeOnDelete()`
- Colonnes booléennes : `->default(false)`
- Ne jamais modifier une migration existante

Génère aussi le rollback `down()` complet.

Arguments : $ARGUMENTS