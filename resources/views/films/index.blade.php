<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Filmek</title>
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  <style>/*style.css*/
    :root{ --ink:#0f172a; --muted:#64748b; --ring:0 0 0 3px rgba(96,165,250,.35); --accent:#60a5fa; }
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Arial,sans-serif;background:#f7fafc;color:var(--ink)}
    .container{max-width:1120px;margin:28px auto;padding:0 16px}

    /* szűrő gombok */
    .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin:12px 0 22px}
    .pill{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:999px;border:1px solid #e2e8f0;background:#fff;color:var(--ink);font-weight:600;text-decoration:none;transition:.15s}
    .pill:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(0,0,0,.06);border-color:#cbd5e1}
    .pill.active{background:linear-gradient(90deg,#ff80b5,#60a5fa);color:#fff;border-color:transparent;box-shadow:0 8px 22px rgba(96,165,250,.25)}

    /* grid + card – ugyanaz, mint a sorozatoknál */
    .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}
    @media(max-width:980px){ .grid{grid-template-columns:repeat(2,minmax(0,1fr));} }
    @media(max-width:640px){ .grid{grid-template-columns:1fr;} }

    .card{
      position:relative;background:#fff;border:1px solid rgba(2,6,23,.08);border-radius:16px;padding:16px;
      text-decoration:none;color:inherit;
      box-shadow:0 1px 2px rgba(2,6,23,.04),0 6px 14px rgba(2,6,23,.06);
      transition:transform .25s cubic-bezier(.2,.8,.2,1),box-shadow .25s,border-color .25s;will-change:transform;
    }
    .card:hover{transform:translateY(-10px) scale(1.02);border-color:rgba(96,165,250,.55);box-shadow:0 24px 48px rgba(2,6,23,.18),0 12px 24px rgba(2,6,23,.12)}
    .hitarea{position:absolute;inset:0;z-index:2}
    .card-body{position:relative;z-index:1}
    .meta{font-size:13px;color:var(--muted);margin:0 0 8px}
    .title{margin:0 0 8px;font-size:20px;font-weight:800}

    /* akció ikonok – törlés / szerkesztés */
    .card-actions{position:absolute;top:10px;right:10px;z-index:4;display:flex;flex-direction:column;gap:8px}
    .icon-btn{width:36px;height:36px;border-radius:9999px;display:grid;place-items:center;cursor:pointer;background:#fff;border:2px solid #e2e8f0;box-shadow:0 6px 14px rgba(2,6,23,.08);opacity:0;transform:translateY(-6px);transition:.2s}
    .card:hover .icon-btn{opacity:1;transform:translateY(0)}
    .icon-btn.is-danger{border-color:#fecaca}.icon-btn.is-danger:hover{border-color:#ef4444;background:#fee2e2;box-shadow:0 0 0 6px rgba(239,68,68,.12),0 12px 24px rgba(2,6,23,.12)}
    .icon-btn.is-primary{border-color:#bfdbfe}.icon-btn.is-primary:hover{border-color:#3b82f6;background:#dbeafe;box-shadow:0 0 0 6px rgba(59,130,246,.12),0 12px 24px rgba(2,6,23,.12)}
    .icon-btn .fa-trash{color:#ef4444;font-size:16px}
    .icon-btn .fa-edit{color:#2563eb;font-size:16px}
  </style>
</head>
<body>
  

  <div class="container">
    <h1>Filmek</h1>

    <nav class="toolbar" aria-label="Típus szűrő">
      <a class="pill {{ $typeParam==='all' ? 'active' : '' }}" href="{{ route('films.index', ['type'=>'all']) }}">Mind</a>
      @foreach($types as $t)
        <a class="pill {{ (string)$t->id === (string)$typeParam ? 'active' : '' }}" href="{{ route('films.index', ['type'=>$t->id]) }}">{{ $t->name }}</a>
      @endforeach
    </nav>

    <section class="grid" aria-live="polite">
      @forelse($films as $film)
        <article class="card">
          <a class="hitarea" href="{{ route('films.show', $film) }}" aria-label="{{ $film->title }} részletei"></a>

          <div class="card-actions">
            <form method="POST" action="{{ route('films.destroy', $film) }}" onsubmit="return confirm('Biztosan törlöd: {{ addslashes($film->title) }}?')" style="margin:0">
              @csrf @method('DELETE')
              <button type="submit" class="icon-btn is-danger" title="Törlés" aria-label="Törlés">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
            <a href="{{ route('films.edit', $film) }}" class="icon-btn is-primary" title="Szerkesztés" aria-label="Szerkesztés">
              <i class="fas fa-edit"></i>
            </a>
          </div>

          <div class="card-body">
            <p class="meta">{{ $film->type?->name ?? '—' }} @if($film->release_date) • {{ $film->release_date->format('Y') }} @endif</p>
            <h3 class="title">{{ $film->title }}</h3>
            <p class="meta">Rendező: {{ $film->director->name }}</p>
            @if($film->length) <p class="meta">Hossz: {{ $film->length }} perc</p> @endif
          </div>
        </article>
      @empty
        <p>Nincs találat ehhez a szűrőhöz.</p>
      @endforelse
    </section>

    <div style="margin-top:14px">{{ $films->links() }}</div>

    <a class="btn" href="{{ route('films.index') }}">
      Back
    </a>

  </div>
</body>
</html>
