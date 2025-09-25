<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Színészek</title>
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  <style>
    :root{ --ink:#0f172a; --muted:#64748b; --ring:0 0 0 3px rgba(96,165,250,.35); }
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Arial,sans-serif;background:#f7fafc;color:var(--ink)}
    .container{max-width:1120px;margin:28px auto;padding:0 16px}

    .grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
    @media(max-width:900px){ .grid{grid-template-columns:1fr;} }

    .card{
      background:#fff;border:1px solid rgba(2,6,23,.08);border-radius:16px;padding:16px;
      box-shadow:0 6px 14px rgba(2,6,23,.06);
      display:grid;grid-template-columns:96px 1fr;gap:16px;
      transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .card:hover{ transform: translateY(-4px); box-shadow:0 18px 36px rgba(2,6,23,.12); border-color:#bfdbfe; }
    .avatar{width:96px;height:96px;border-radius:12px;object-fit:cover;background:#e2e8f0;border:1px solid #e5e7eb}
    .name{margin:0 0 6px;font-size:20px;font-weight:800}
    .meta{margin:0 0 10px;color:var(--muted);font-size:14px}

    .chips{display:flex;flex-wrap:wrap;gap:8px}
    .chip{
      display:inline-flex;align-items:center;gap:6px;padding:7px 10px;border-radius:999px;
      background:#f1f5f9;border:1px solid #e2e8f0;color:#0f172a;font-size:13px;text-decoration:none;
      transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
    }
    .chip:hover{ transform: translateY(-1px); box-shadow:0 8px 16px rgba(2,6,23,.08); border-color:#cbd5e1 }
    .chip .badge{font-size:11px;color:#475569}

    /* külön szín film / sorozat jelöléshez */
    .chip.series{ background:#e0f2fe; border-color:#bfdbfe }

    /* főszerep kiemelés felülírja az alapot */
    .chip.lead{ background:#dcfce7 !important; border-color:#86efac !important }

    .section-title{font-weight:700;margin:10px 0 6px}
  </style>
</head>
<body>
  @include('partials.nav')

  <div class="container">
    <h1 style="margin:0 0 10px">Színészek</h1>
    <p class="meta" style="margin:0 0 16px">Kattints egy film vagy sorozat címkére a részletekhez.</p>

    <section class="grid">
      @forelse($actors as $actor)
        <article class="card">
          <img class="avatar" src="{{ $actor->image_url }}" alt="{{ $actor->name }}">
          <div>
            @php
              $filmCount   = $actor->films->count();
              $seriesCount = $actor->series->count();
            @endphp

            <h3 class="name">{{ $actor->name }}</h3>
            <p class="meta">
              Filmek: {{ $filmCount }}
              @if($seriesCount) • Sorozatok: {{ $seriesCount }} @endif
            </p>

            @if($filmCount || $seriesCount)
              @if($filmCount)
                <div class="section-title">Filmek</div>
                <div class="chips">
                  @foreach($actor->films as $f)
                    <a class="chip film {{ $f->pivot->is_lead ? 'lead' : '' }}"
                       href="{{ route('films.show', $f) }}">
                      {{ $f->title }}
                      <span class="badge">• {{ $f->release_date?->format('Y') }}</span>
                      @if($f->pivot->is_lead) <span class="badge">főszerep</span> @endif
                    </a>
                  @endforeach
                </div>
              @endif

              @if($seriesCount)
                <div class="section-title" style="margin-top:10px">Sorozatok</div>
                <div class="chips">
                  @foreach($actor->series as $s)
                    <a class="chip series {{ $s->pivot->is_lead ? 'lead' : '' }}"
                       href="{{ route('series.show', $s) }}">
                      {{ $s->title }}
                      <span class="badge">• {{ $s->release_date?->format('Y') }}</span>
                      @if($s->pivot->is_lead) <span class="badge">főszerep</span> @endif
                    </a>
                  @endforeach
                </div>
              @endif
            @else
              <p class="meta">Nincs hozzárendelt film/sorozat.</p>
            @endif
          </div>
        </article>
      @empty
        <p>Nincs még színész az adatbázisban.</p>
      @endforelse
    </section>

    <div style="margin-top:14px">{{ $actors->links() }}</div>
  </div>
</body>
</html>
