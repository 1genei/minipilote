/* Minipilote — rail (Power Platform style), top bar, app composition, tweaks */

const TWEAK_DEFAULTS = /*EDITMODE-BEGIN*/{
  "variant": "fidele",
  "accent": "#2d1b5e",
  "mode": "rail",
  "showHeaderLabel": true
}/*EDITMODE-END*/;

const ACCENT_TINTS = {
  "#2d1b5e": "#ece8f6",
  "#0b6a5f": "#e0f0ec",
  "#2a6fdb": "#e6eefb",
  "#f9c851": "#fdf3d8",
};
function tintFor(hex) { return ACCENT_TINTS[hex.toLowerCase()] || "#eef0f4"; }
function isLight(hex) { return hex.toLowerCase() === "#f9c851"; }

/* ---------------- Flyout panel ---------------- */
function Flyout({ item, top, activeChild, onPick, onEnter, onLeave }) {
  if (!item) return null;
  return (
    <div className="mp-flyout" style={{ top }} onMouseEnter={onEnter} onMouseLeave={onLeave}>
      <div className="mp-flyout-title">{item.short || item.label}</div>
      <ul className="mp-flyout-list">
        {item.children.map((c, i) => (
          <li key={i}>
            <a href="#" className={activeChild === c.label ? "is-active" : ""}
              onClick={(e) => { e.preventDefault(); onPick(item, c); }}>
              {c.label}
            </a>
          </li>
        ))}
      </ul>
    </div>
  );
}

/* ---------------- Rail item ---------------- */
function RailItem({ item, mode, active, onHover, onLeave, onClick }) {
  const hasKids = !!item.children;
  return (
    <button
      className={"mp-item" + (active ? " is-active" : "") + (hasKids ? " has-kids" : "")}
      onMouseEnter={(e) => onHover(item, e.currentTarget)}
      onMouseLeave={onLeave}
      onClick={() => onClick(item)}
      data-tip={item.short || item.label}
    >
      <span className="mp-item-tile"><Icon name={item.icon} size={22} /></span>
      {mode !== "icons" && (
        <span className="mp-item-label">
          {item.label}
          {hasKids && mode === "expanded" && <span className="mp-acc-arrow"><Icon name="chevronDown" size={14} /></span>}
        </span>
      )}
      {hasKids && mode !== "expanded" && <span className="mp-item-kidcue"><Icon name="chevron" size={12} /></span>}
    </button>
  );
}

/* ---------------- Rail ---------------- */
function Rail({ t, active, setActive, mode, setMode }) {
  const [fly, setFly] = React.useState(null); // {item, top}
  const [openSecs, setOpenSecs] = React.useState({ [active.id]: true });
  const closeTimer = React.useRef(null);
  const railRef = React.useRef(null);

  const cancelClose = () => { if (closeTimer.current) clearTimeout(closeTimer.current); };
  const scheduleClose = () => { cancelClose(); closeTimer.current = setTimeout(() => setFly(null), 180); };

  const onHover = (item, el) => {
    if (mode === "expanded") return;
    if (!item.children) { setFly(null); return; }
    cancelClose();
    const railTop = railRef.current.getBoundingClientRect().top;
    const r = el.getBoundingClientRect();
    setFly({ item, top: r.top - railTop });
  };

  const pickChild = (item, child) => {
    setActive({ id: item.id, child: child.label });
    setFly(null);
  };

  const onItemClick = (item) => {
    if (mode === "expanded") {
      if (item.children) { setOpenSecs(s => ({ ...s, [item.id]: !s[item.id] })); return; }
      setActive({ id: item.id, child: null });
      return;
    }
    if (item.children) {
      setActive({ id: item.id, child: item.children[0].label });
      setFly(null);
    } else {
      setActive({ id: item.id, child: null });
      setFly(null);
    }
  };

  const RAIL_WIDTHS = { icons: 68, rail: 96, expanded: 256 };
  return (
    <nav className={"mp-rail mp-mode-" + mode} ref={railRef}
      style={{ flex: "0 0 " + RAIL_WIDTHS[mode] + "px" }}
      onMouseLeave={scheduleClose}>
      <div className="mp-rail-top">
        <button className="mp-brand" title="Minipilote">
          <span className="mp-brand-mark">M</span>
          {mode === "expanded" && <span className="mp-brand-word">Minipilote</span>}
        </button>
        <button className="mp-hamburger" title="Replier / déplier"
          onClick={() => setMode(mode === "expanded" ? "rail" : "expanded")}>
          <Icon name="menu" size={20} />
        </button>
      </div>

      <div className="mp-rail-scroll">
        {window.MP_NAV.map((item) => (
          <React.Fragment key={item.id}>
            <RailItem item={item} mode={mode} active={active.id === item.id}
              onHover={onHover} onLeave={scheduleClose} onClick={onItemClick} />
            {mode === "expanded" && item.children && openSecs[item.id] && (
              <ul className="mp-acc-list">
                {item.children.map((c, i) => (
                  <li key={i}>
                    <a href="#" className={active.id === item.id && active.child === c.label ? "is-active" : ""}
                      onClick={(e) => { e.preventDefault(); setActive({ id: item.id, child: c.label }); }}>
                      {c.label}
                    </a>
                  </li>
                ))}
              </ul>
            )}
          </React.Fragment>
        ))}
      </div>

      {mode !== "expanded" && (
        <Flyout item={fly && fly.item} top={fly && fly.top} activeChild={active.child}
          onPick={pickChild} onEnter={cancelClose} onLeave={scheduleClose} />
      )}
    </nav>
  );
}

/* ---------------- Top bar ---------------- */
function TopBar({ showLabel }) {
  return (
    <header className="mp-topbar">
      <button className="mp-top-btn mp-launcher" title="Modules"><Icon name="grid9" size={20} /></button>
      <div className="mp-top-title">
        <span className="mp-top-product">Minipilote</span>
        {showLabel && <span className="mp-top-sep">|</span>}
        {showLabel && <span className="mp-top-context">Gestion de pilotage</span>}
      </div>
      <div className="mp-top-search">
        <Icon name="search" size={16} />
        <input placeholder="Rechercher un client, une session, un devis…" />
      </div>
      <div className="mp-top-right">
        <button className="mp-top-btn" title="Aide"><Icon name="help" size={20} /></button>
        <button className="mp-top-btn" title="Notifications"><span className="mp-dot" /><Icon name="bell" size={20} /></button>
        <button className="mp-top-btn" title="Paramètres"><Icon name="settings" size={20} /></button>
        <button className="mp-avatar" title="Jean-Pierre">JP</button>
      </div>
    </header>
  );
}

/* ---------------- App ---------------- */
function App() {
  const [t, setTweak] = useTweaks(TWEAK_DEFAULTS);
  const [active, setActive] = React.useState({ id: "dashboard", child: null });
  const [mode, setMode] = React.useState(t.mode);

  // sync tweak mode -> live mode
  React.useEffect(() => { setMode(t.mode); }, [t.mode]);

  const item = window.MP_NAV.find(n => n.id === active.id) || window.MP_NAV[0];
  const accent = t.accent;
  const rootStyle = {
    "--mp-accent": accent,
    "--mp-accent-tint": tintFor(accent),
    "--mp-on-accent": isLight(accent) ? "#2a2118" : "#ffffff",
  };

  return (
    <div className="mp-root" data-variant={t.variant} style={rootStyle}>
      <Rail t={t} active={active} setActive={setActive} mode={mode} setMode={setMode} />
      <div className="mp-main">
        <TopBar showLabel={t.showHeaderLabel} />
        <div className="mp-content">
          {active.id === "dashboard"
            ? <Dashboard />
            : <GenericPage item={item} sub={active.child} />}
        </div>
      </div>

      <TweaksPanel>
        <TweakSection label="Style du rail" />
        <TweakRadio label="Variation" value={t.variant}
          options={["fidele", "accent", "tuile"]}
          onChange={(v) => setTweak("variant", v)} />
        <TweakSection label="Affichage" />
        <TweakRadio label="Mode" value={t.mode}
          options={["icons", "rail", "expanded"]}
          onChange={(v) => setTweak("mode", v)} />
        <TweakToggle label="Sous-titre en-tête" value={t.showHeaderLabel}
          onChange={(v) => setTweak("showHeaderLabel", v)} />
        <TweakSection label="Couleur de marque" />
        <TweakColor label="Accent" value={t.accent}
          options={["#2d1b5e", "#0b6a5f", "#2a6fdb", "#f9c851"]}
          onChange={(v) => setTweak("accent", v)} />
      </TweaksPanel>
    </div>
  );
}

ReactDOM.createRoot(document.getElementById("root")).render(<App />);
