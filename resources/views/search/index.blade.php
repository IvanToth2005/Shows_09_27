<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keresés</title>
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  <style>
    :root{ --ink:#0f172a; --muted:#64748b; }
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Arial,sans-serif;background:#f7fafc;color:var(--ink)}
    .container{max-width:1120px;margin:28px auto;padding:0 16px}

    .meta{color:var(--muted);font-size:14px;margin:0 0 8px}
    h2{margin:18px 0 10px}

    .grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
    @media(max-width:900px){ .grid{grid-template-columns:1fr} }

    .card{background:#fff;border:1px solid rgba(2,6,23,.08);border-radius:14px;padding:14px;text-decoration:none;color:inherit;
      box-shadow:0 6px 14px rgba(2,6,23,.06); transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease}
    .card:hover{ transform:translateY(-3px); border-color:#bfdbfe; box-shadow:0 16px 28px rgba(2,6,23,.12) }
    .title{margin:0 0 6px;font-weight:800}
    .chips{display:flex;flex-wrap:wrap;gap:8px;margin-top:6px}
    .chip{padding:6px 10px;border-radius:999px;background:#f1f5f9;border:1px solid #e2e8f0;color:#0f172a;font-size:12px}
    .chip.lead{background:#dcfce7;border-color:#86efac}
  </style>
</head>
<body>
  @include('partials.nav')

  <div class="container">
    <h1>Keresés</h1>
    <form action="{{ route('search.index') }}" method="GET" role="search" style="margin:8px 0 16px">
      <input type="text" name="q" value="{{ $q }}" placeholder="Írj be egy címet vagy nevet…" style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:12px">
    </form>

    @if($q === '')
      <p class="meta">Írj be valamit a kereséshez.</p>
    @else
      <p class="meta">Találatok a(z) „<strong>{{ $q }}</strong>” kifejezésre.</p>

      {{-- FILMEK --}}
      <h2>Filmek ({{ $films->count() }})</h2>
      @if($films->isEmpty())
        <p class="meta">Nincs találat.</p>
      @else
        <div class="grid">
          @foreach($films as $f)
            <a class="card" href="{{ route('films.show', $f) }}">
              <p class="meta">{{ $f->type?->name ?? '—' }} • {{ $f->release_date?->format('Y') ?? '—' }}</p>
              <h3 class="title">{{ $f->title }}</h3>
              <p class="meta">Rendező: {{ $f->director?->name ?? '—' }} @if($f->length) • Hossz: {{ $f->length }} perc @endif</p>
              @if($f->actors->count())
                <div class="chips">
                  @foreach($f->actors->take(6) as $a)
                    <span class="chip {{ $a->pivot->is_lead ? 'lead' : '' }}">{{ $a->name }}</span>
                  @endforeach
                </div>
              @endif
            </a>
          @endforeach
        </div>
      @endif

      {{-- SOROZATOK --}}
      <h2 style="margin-top:18px">Sorozatok ({{ $series->count() }})</h2>
      @if($series->isEmpty())
        <p class="meta">Nincs találat.</p>
      @else
        <div class="grid">
          @foreach($series as $s)
            <a class="card" href="{{ route('series.show', $s) }}">
              <p class="meta">{{ $s->type?->name ?? '—' }} • {{ $s->release_date?->format('Y') ?? '—' }}</p>
              <h3 class="title">{{ $s->title }}</h3>
              <p class="meta">Rendező: {{ $s->director?->name ?? '—' }} @if($s->length) • Ep. hossz: {{ $s->length }} perc @endif</p>
              @if($s->actors->count())
                <div class="chips">
                  @foreach($s->actors->take(6) as $a)
                    <span class="chip {{ $a->pivot->is_lead ? 'lead' : '' }}">{{ $a->name }}</span>
                  @endforeach
                </div>
              @endif
            </a>
          @endforeach
        </div>
      @endif

      {{-- SZÍNÉSZEK --}}
      <h2 style="margin-top:18px">Színészek ({{ $actors->count() }})</h2>
      @if($actors->isEmpty())
        <p class="meta">Nincs találat.</p>
      @else
        <div class="grid">
          @foreach($actors as $actor)
            <div class="card">
              <h3 class="title">{{ $actor->name }}</h3>
              <p class="meta">Filmek: {{ $actor->films->count() }}</p>
              @if($actor->films->count())
                <div class="chips">
                  @foreach($actor->films as $f)
                    <a class="chip {{ $f->pivot->is_lead ? 'lead' : '' }}" href="{{ route('films.show', $f) }}">
                      {{ $f->title }} <span class="meta" style="font-size:11px">• {{ $f->release_date?->format('Y') }}</span>
                    </a>
                  @endforeach
                </div>
              @endif
            </div>
          @endforeach
        </div>
      @endif
    @endif
  </div>
</body>
</html>
