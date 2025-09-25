<nav class="site-nav" role="navigation" aria-label="Fő navigáció">
  <style>
    .site-nav{position:sticky;top:0;z-index:1000;background:rgba(255,255,255,.75);
      -webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);
      border-bottom:1px solid rgba(15,23,42,.06)}
    .site-nav .inner{max-width:1100px;margin:0 auto;padding:10px 16px;
      display:flex;align-items:center;justify-content:space-between}
    .brand{font-weight:800;text-decoration:none;color:#0f172a;font-size:18px}
    .links{display:flex;gap:10px;align-items:center}
    .links a{color:#0f172a;text-decoration:none;padding:8px 12px;border-radius:10px}
    .links a:hover{background:#e2e8f0}
    .links a.active{background:#e0f2fe;border:1px solid #60a5fa}
    .menu-toggle{display:none;background:none;border:0;cursor:pointer;padding:8px}
    .menu-toggle .bar{display:block;width:22px;height:2px;background:#0f172a;margin:4px 0;transition:all .2s}
    @media (max-width:768px){
      .menu-toggle{display:block}
      .links{display:none;position:absolute;right:16px;top:54px;background:#fff;
        border:1px solid #e5e7eb;border-radius:12px;padding:10px;flex-direction:column;min-width:170px}
      .site-nav.open .links{display:flex}
      .site-nav.open .menu-toggle .bar:nth-child(1){transform:translateY(6px) rotate(45deg)}
      .site-nav.open .menu-toggle .bar:nth-child(2){opacity:0}
      .site-nav.open .menu-toggle .bar:nth-child(3){transform:translateY(-6px) rotate(-45deg)}
      }
    .gsearch{
      position:relative;
      margin-left:auto;                  /* a logó és a linkek közé illeszkedik */
      width:520px; max-width:42vw;
    }
    @media (max-width:900px){
      .gsearch{ display:none; }          /* mobilon elrejthető; később csinálhatunk külön kereső oldalt */
    }
    .gsearch input{
      width:100%; height:44px;
      padding:0 44px;                    /* hely az ikonoknak */
      border:1px solid #dfe1e5;
      border-radius:9999px;
      background:#fff;
      font:inherit;
      box-shadow:0 1px 3px rgba(60,64,67,.16);
      transition:box-shadow .2s, border-color .2s;
    }
    .gsearch:hover input{
      border-color:#dadce0;
      box-shadow:0 1px 6px rgba(32,33,36,.16);
    }
    .gsearch input:focus{
      outline:none;
      border-color:#dadce0;
      box-shadow:0 1px 6px rgba(32,33,36,.28);
    }
    .gsearch .fa-magnifying-glass{
      position:absolute; left:14px; top:50%; transform:translateY(-50%);
      color:#5f6368; font-size:16px; pointer-events:none;
    }
    .gsearch .clear-btn{
      position:absolute; right:10px; top:50%; transform:translateY(-50%);
      width:28px; height:28px; border-radius:999px; border:0;
      display:none; place-items:center;
      font-size:18px; color:#5f6368;
      background:#f1f3f4; cursor:pointer;
    }
    .gsearch.has-value .clear-btn{ display:grid; }
  </style>

  <div class="inner">
    <a href="{{ route('home') }}" class="brand">🎬 Media</a>

  <form action="{{ route('search.index') }}" method="GET"
        class="gsearch" role="search" aria-label="Keresés">
    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
    <input type="text" name="q" value="{{ request('q') }}"
          placeholder="Keresés filmre, sorozatra vagy színészre…" autocomplete="off" />
    <button type="button" class="clear-btn" aria-label="Mező törlése">×</button>
  </form>
    <button class="menu-toggle" aria-expanded="false" aria-controls="nav-links">
      <span class="bar"></span><span class="bar"></span><span class="bar"></span>
      <span class="sr-only">Menü</span>
    </button>

    <div id="nav-links" class="links">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Főoldal</a>
      <a href="{{ route('films.index') }}" class="{{ request()->routeIs('films.*') ? 'active' : '' }}">Filmek</a>
      <a href="{{ route('series.index') }}" class="{{ request()->routeIs('series.*') ? 'active' : '' }}">Sorozatok</a>
      <a href="{{ route('actors.index') }}" class="{{ request()->routeIs('actors.*') ? 'active' : '' }}">Színészek</a>

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function(){
      const nav = document.querySelector('.site-nav');
      const btn = nav.querySelector('.menu-toggle');
      btn.addEventListener('click', () => {
        const open = nav.classList.toggle('open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    });
  </script>
</nav>
