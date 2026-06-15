/* Minipilote — structure du menu (reprise fidèle du nav Blade existant). */
window.MP_NAV = [
  { id: 'dashboard', label: 'Tableau\u00A0de\u00A0bord', short: 'Tableau de bord', icon: 'dashboard', route: 'welcome' },
  { id: 'utilisateurs', label: 'Utilisateurs', icon: 'users',
    children: [
      { label: 'Gestion', route: 'utilisateur.index' },
      { label: 'Droits', route: 'permission.index' },
    ] },
  { id: 'contacts', label: 'Contacts', icon: 'contacts',
    children: [
      { label: 'Collaborateurs', route: 'collaborateur.index' },
      { label: 'Prospects', route: 'prospect.index' },
      { label: 'Clients', route: 'client.index' },
      { label: 'Fournisseurs', route: 'fournisseur.index' },
      { label: 'Tous les contacts', route: 'contact.index' },
    ] },
  { id: 'planning', label: 'Planning', icon: 'planning', route: 'planning.index' },
  { id: 'catalogue', label: 'Catalogue', icon: 'catalogue',
    children: [
      { label: 'Produits', route: 'produit.index' },
      { label: 'Caract\u00E9ristiques', route: 'caracteristique.index' },
    ] },
  { id: 'affaires', label: 'Affaires', icon: 'affaires',
    children: [
      { label: 'Gestion', route: '#' },
      { label: 'Propositions commerciales', route: '#' },
      { label: 'Devis', route: 'devis.index' },
      { label: 'Commandes', route: 'commande.index' },
      { label: 'Factures', route: 'facture.index' },
    ] },
  { id: 'evenements', label: 'Év\u00E8nements', icon: 'events', route: 'evenement.index' },
  { id: 'prestations', label: 'Prestations', icon: 'prestations', route: 'prestation.index' },
  { id: 'agenda', label: 'Agenda', icon: 'agenda', route: 'agenda.listing' },
  { id: 'parametres', label: 'Paramètres', icon: 'settings', route: 'parametre.index' },
];
