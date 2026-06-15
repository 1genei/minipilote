/* Minipilote — app shell mock (contenu de droite : tableau de bord + pages génériques) */

function Icon({ name, size = 22, sw = 1.6 }) {
  const inner = window.MP_ICONS[name] || '';
  return (
    <svg width={size} height={size} viewBox="0 0 24 24" fill="none"
      stroke="currentColor" strokeWidth={sw} strokeLinecap="round" strokeLinejoin="round"
      dangerouslySetInnerHTML={{ __html: inner }} />
  );
}
window.Icon = Icon;

/* ---------------- KPI + dashboard widgets ---------------- */
function Kpi({ label, value, sub, trend }) {
  return (
    <div className="mp-card mp-kpi">
      <div className="mp-kpi-label">{label}</div>
      <div className="mp-kpi-value">{value}</div>
      <div className={"mp-kpi-sub " + (trend > 0 ? "up" : trend < 0 ? "down" : "")}>
        {trend > 0 ? "▲ " : trend < 0 ? "▼ " : ""}{sub}
      </div>
    </div>
  );
}

const SESSIONS = [
  { t: "08:30", dur: "1h30", circuit: "Circuit du Var — GT", voiture: "Porsche 911 GT3", client: "M. Lefèvre", st: "Confirmée" },
  { t: "10:30", dur: "2h00", circuit: "Le Castellet — Initiation", voiture: "Alpine A110", client: "SARL Drivexpé", st: "Confirmée" },
  { t: "13:00", dur: "1h00", circuit: "Le Castellet — Baptême", voiture: "BMW M4 Comp.", client: "Mme Garnier", st: "À confirmer" },
  { t: "15:30", dur: "2h30", circuit: "Circuit du Var — Stage", voiture: "Audi RS3", client: "Comité Renault", st: "Confirmée" },
];

const AFFAIRES = [
  { ref: "DEV-2026-0418", client: "Comité d'entreprise Renault", date: "06 juin", montant: "12 400 €", st: "Devis" },
  { ref: "CMD-2026-0211", client: "SARL Drivexpérience", date: "04 juin", montant: "8 950 €", st: "Commande" },
  { ref: "FAC-2026-0177", client: "M. Lefèvre Jean-Pierre", date: "02 juin", montant: "1 290 €", st: "Facturé" },
  { ref: "DEV-2026-0415", client: "Mme Garnier Sophie", date: "01 juin", montant: "640 €", st: "Devis" },
];

function StatusPill({ st }) {
  const map = {
    "Confirmée": "ok", "Facturé": "ok", "Commande": "info",
    "Devis": "warn", "À confirmer": "warn",
  };
  return <span className={"mp-pill mp-pill-" + (map[st] || "info")}>{st}</span>;
}

function Dashboard() {
  return (
    <div className="mp-page">
      <div className="mp-page-head">
        <div>
          <div className="mp-crumb">Accueil</div>
          <h1 className="mp-h1">Bonjour Jean-Pierre</h1>
          <p className="mp-sub">Voici l'activité de votre structure de pilotage pour aujourd'hui.</p>
        </div>
        <div className="mp-head-actions">
          <button className="mp-btn mp-btn-ghost"><Icon name="agenda" size={16}/> Cette semaine</button>
          <button className="mp-btn mp-btn-primary">+ Nouvelle session</button>
        </div>
      </div>

      <div className="mp-kpis">
        <Kpi label="Sessions planifiées" value="18" sub="+4 vs sem. dernière" trend={1} />
        <Kpi label="Voitures disponibles" value="7 / 9" sub="2 en maintenance" trend={0} />
        <Kpi label="Devis en attente" value="5" sub="2 à relancer" trend={-1} />
        <Kpi label="CA du mois" value="48 250 €" sub="+12 % objectif" trend={1} />
      </div>

      <div className="mp-grid2">
        <div className="mp-card">
          <div className="mp-card-head">
            <h2 className="mp-h2">Planning du jour</h2>
            <a className="mp-link" href="#">Voir le planning</a>
          </div>
          <div className="mp-sessions">
            {SESSIONS.map((s, i) => (
              <div className="mp-session" key={i}>
                <div className="mp-session-time"><b>{s.t}</b><span>{s.dur}</span></div>
                <div className="mp-session-bar" />
                <div className="mp-session-main">
                  <div className="mp-session-title">{s.circuit}</div>
                  <div className="mp-session-meta">{s.voiture} · {s.client}</div>
                </div>
                <StatusPill st={s.st} />
              </div>
            ))}
          </div>
        </div>

        <div className="mp-card">
          <div className="mp-card-head">
            <h2 className="mp-h2">Affaires récentes</h2>
            <a className="mp-link" href="#">Voir tout</a>
          </div>
          <table className="mp-table">
            <thead><tr><th>Référence</th><th>Client</th><th>Montant</th><th>Statut</th></tr></thead>
            <tbody>
              {AFFAIRES.map((a, i) => (
                <tr key={i}>
                  <td className="mp-mono">{a.ref}</td>
                  <td>{a.client}<div className="mp-td-sub">{a.date}</div></td>
                  <td className="mp-num">{a.montant}</td>
                  <td><StatusPill st={a.st} /></td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}

/* Generic page scaffold for non-dashboard items */
function GenericPage({ item, sub }) {
  const cols = {
    utilisateurs: ["Nom", "E-mail", "Rôle", "Statut"],
    contacts: ["Contact", "Type", "Téléphone", "Ville"],
    catalogue: ["Produit", "Référence", "Catégorie", "Prix"],
    affaires: ["Référence", "Client", "Montant", "Statut"],
    planning: ["Créneau", "Circuit", "Voiture", "Statut"],
    agenda: ["Date", "Évènement", "Responsable", "Statut"],
  }[item.id] || ["Nom", "Détail", "Date", "Statut"];

  return (
    <div className="mp-page">
      <div className="mp-page-head">
        <div>
          <div className="mp-crumb">{sub ? item.short || item.label : "Minipilote"}</div>
          <h1 className="mp-h1">{sub || item.short || item.label}</h1>
          <p className="mp-sub">Module « {(item.short || item.label).toString().replace(/\u00A0/g,' ')} » — vue de gestion.</p>
        </div>
        <div className="mp-head-actions">
          <button className="mp-btn mp-btn-ghost"><Icon name="search" size={16}/> Rechercher</button>
          <button className="mp-btn mp-btn-primary">+ Ajouter</button>
        </div>
      </div>
      <div className="mp-card">
        <div className="mp-toolbar">
          <div className="mp-search-field"><Icon name="search" size={15}/><input placeholder="Filtrer…" /></div>
          <div className="mp-chip">Tous</div>
          <div className="mp-chip">Récents</div>
        </div>
        <table className="mp-table">
          <thead><tr>{cols.map((c,i)=><th key={i}>{c}</th>)}</tr></thead>
          <tbody>
            {[0,1,2,3,4].map(r => (
              <tr key={r}>
                {cols.map((c,i)=>(
                  <td key={i}>
                    {i===0 ? <span className="mp-skel mp-skel-strong" style={{width: 120 - r*8}}/> : <span className="mp-skel" style={{width: 90 - i*10}}/>}
                  </td>
                ))}
              </tr>
            ))}
          </tbody>
        </table>
        <div className="mp-empty-note">Données de démonstration — le contenu réel sera branché sur vos routes Laravel.</div>
      </div>
    </div>
  );
}
window.Dashboard = Dashboard;
window.GenericPage = GenericPage;
