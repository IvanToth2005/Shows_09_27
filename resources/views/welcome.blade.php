<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kezdőlap – Mit szeretnél nézni?</title>
  <style>
  :root{
    --txt: #0f172a;         
    --muted: #64748b;     
    --accent1:#ff80b5;      
    --accent2:#60a5fa;     
    --accent3:#34d399;      
    --card:#ffffff;         
    --border:#eef2ff;      
  }

  *{ box-sizing: border-box; }
  body{
    margin:0;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Arial, sans-serif;
    color:var(--txt);

    background:
      radial-gradient(70% 60% at 15% 0%, #fff1f2 0%, transparent 60%),
      radial-gradient(60% 50% at 85% 10%, #e0f2fe 0%, transparent 60%),
      radial-gradient(80% 70% at 50% 100%, #fef9c3 0%, transparent 65%),
      linear-gradient(180deg, #ffffff 0%, #fff7ed 100%);
    min-height:100vh;
    display:flex; align-items:center; justify-content:center; padding:24px;
  }

  .container{ width:100%; max-width:1100px; }
  header{ text-align:center; margin-bottom:28px; }
  header h1{ margin:0 0 8px; font-weight:800; letter-spacing:.2px; }
  header p{ margin:0; color:var(--muted); }

  .grid{ display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:24px; }
  @media (max-width:720px){ .grid{ grid-template-columns:1fr; } }

  .card{
    position:relative; isolation:isolate;
    background: linear-gradient(180deg, rgba(255,255,255,1), rgba(255,255,255,.96));
    border:1px solid var(--border);
    border-radius:20px; padding:28px;
    box-shadow: 0 10px 30px rgba(255,128,181,.08), 0 6px 20px rgba(96,165,250,.08);
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    overflow:hidden;
  }
  .card:hover{
    transform: translateY(-3px);
    border-color: rgba(96,165,250,.55);
    box-shadow: 0 18px 40px rgba(96,165,250,.18), 0 10px 24px rgba(255,128,181,.12);
  }
  .card::after{
    content:"";
    position:absolute; inset:-40% -10% auto auto;
    width:60%; height:160%;
    background: radial-gradient(60% 60% at 50% 50%, rgba(255,128,181,.18), transparent 70%),
                radial-gradient(40% 40% at 30% 30%, rgba(96,165,250,.18), transparent 70%);
    transform: rotate(20deg);
    pointer-events:none; z-index:-1;
  }

  .eyebrow{ color:var(--muted); font-size:12px; text-transform:uppercase; letter-spacing:.14em; }
  .title{ font-size:28px; margin:6px 0 10px; font-weight:800; }
  .desc{ color:var(--muted); margin:0 0 18px; line-height:1.5; }

  .count{
    display:inline-block; font-size:13px; padding:6px 10px; border-radius:999px;
    background: linear-gradient(90deg, rgba(255,128,181,.15), rgba(96,165,250,.15));
    color:#334155; border:1px solid #fde2e8;
  }

  .actions{ display:flex; gap:12px; flex-wrap:wrap; margin-top:18px; }

  .btn{
    display:inline-flex; align-items:center; justify-content:center;
    padding:12px 16px; border-radius:12px; text-decoration:none; border:0; font-weight:800;
    color:#ffffff;
    background: linear-gradient(90deg, var(--accent1), var(--accent2));
    box-shadow: 0 8px 18px rgba(255,128,181,.25);
    transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
  }
  .btn:hover{ transform: translateY(-1px); box-shadow: 0 12px 26px rgba(96,165,250,.28); filter:saturate(1.05); }

  .btn.secondary{
    background:#ffffff; color:var(--txt);
    border:1px solid #e2e8f0;
    box-shadow:none; font-weight:700;
  }
  .btn.secondary:hover{
    border-color: rgba(52,211,153,.6);
    box-shadow: 0 6px 16px rgba(52,211,153,.18);
  }

  .icon{ width:22px; height:22px; margin-right:8px; }
</style>
</head>
<body>
  <div class="container" role="main">
    <header>
      <h1>Mit szeretnél nézni?</h1>
      <p>Válaszd ki a kategóriát: filmek vagy sorozatok.</p>
    </header>

    <div class="grid">
      <!-- FILMEK -->
      <section class="card" aria-labelledby="filmek-cim">
        <div class="eyebrow">Kategória</div>
        <h2 id="filmek-cim" class="title">Filmek</h2>
        <p class="desc">Böngéssz a mozifilmek között, részletekkel, szereplőkkel és rendezőkkel.</p>
        <span class="count">{{ number_format($filmCount ?? 0, 0, ',', ' ') }} db</span>
        <div class="actions">
          <a class="btn" href="{{ route('films.index') }}">
            <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M4 5h2v2H4V5Zm0 6h2v2H4v-2Zm0 6h2v2H4v-2ZM8 5h12v14H8V5Zm3 3h6v2h-6V8Zm0 4h6v2h-6v-2Z" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            Filmek megnyitása
          </a>
          <a class="btn secondary" href="{{ route('films.create') }}">Új film hozzáadása</a>
        </div>
      </section>

      <!-- SOROZATOK -->
      <section class="card" aria-labelledby="sorozatok-cim">
        <div class="eyebrow">Kategória</div>
        <h2 id="sorozatok-cim" class="title">Sorozatok</h2>
        <p class="desc">Találd meg kedvenc sorozataidat, epizód hosszokkal és szereplőkkel.</p>
        <span class="count">{{ number_format($seriesCount ?? 0, 0, ',', ' ') }} db</span>
        <div class="actions">
          <a class="btn" href="{{ route('series.index') }}">
            <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M4 6h16v12H4V6Zm3 3h4v2H7V9Zm0 4h10v2H7v-2Z" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            Sorozatok megnyitása
          </a>
          <a class="btn secondary" href="{{ route('series.create') }}">Új sorozat hozzáadása</a>
        </div>
      </section>
    </div>
  </div>
</body>
</html>
