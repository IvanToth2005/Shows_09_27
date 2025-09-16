<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Filmek</title>
  <style>
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Arial,sans-serif;background:#fafafa;color:#0f172a}
    .container{max-width:1100px;margin:32px auto;padding:0 16px}
    .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin:8px 0 20px}
    .pill{display:inline-block;padding:8px 12px;border:1px solid #e2e8f0;border-radius:999px;text-decoration:none;color:#0f172a;background:#fff}
    .pill.active{border-color:#60a5fa;background:#e0f2fe}
    .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
    @media(max-width:900px){.grid{grid-template-columns:repeat(2,minmax(0,1fr));}}
    @media(max-width:600px){.grid{grid-template-columns:1fr;}}
    .card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:14px}
    .meta{font-size:13px;color:#64748b;margin:0 0 8px}
    .title{margin:0 0 6px}
    .small{font-size:13px;color:#475569;margin:0}
    .muted{color:#64748b}
  </style>
</head>
<body>
  <div class="container">
    <h1>Filmek</h1>

    <!-- SZŰRŐ: Mind + Műfajok -->
    <nav class="toolbar" aria-label="Típus szűrő">
    <a class="pill {{ $typeParam==='all' ? 'active' : '' }}"
        href="{{ route('films.index', ['type'=>'all']) }}">Mind</a>
    @foreach($types as $t)
        <a class="pill {{ (string)$t->id === (string)$typeParam ? 'active' : '' }}"
        href="{{ route('films.index', ['type'=>$t->id]) }}">{{ $t->name }}</a>
    @endforeach
    </nav>

    <!-- LISTA -->
    <section class="grid" aria-live="polite">
      @forelse($films as $film)
        <article class="card">
            <p class="meta">
                {{ $film->type?->name ?? '—' }} • {{ $film->release_date?->format('Y') ?? '—' }}
            </p>
          <h3 class="title">{{ $film->title }}</h3>
          <p class="small">Rendező: {{ $film->director->name }}</p>
          @if($film->length)
            <p class="small muted">Hossz: {{ $film->length }} perc</p>
          @endif
        </article>
      @empty
        <p>Nincs találat ehhez a szűrőhöz.</p>
      @endforelse
    </section>

    <div style="margin-top:14px">{{ $films->links() }}</div>
  </div>
</body>
</html>
