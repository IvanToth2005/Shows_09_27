<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $film->title }} – Film adatlap</title>
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  <style>
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Arial,sans-serif;background:#fafafa;color:#0f172a}
    .container{max-width:1100px;margin:24px auto;padding:0 16px}
    .back{display:inline-block;margin:8px 0 16px;text-decoration:none;color:#2563eb}
    .wrap{display:grid;grid-template-columns:420px 1fr;gap:24px}
    @media(max-width:960px){ .wrap{grid-template-columns:1fr} }

    .poster-wrap{
      background:#fff;
      border:1px solid #e5e7eb;
      border-radius:14px;
      overflow:hidden;
      aspect-ratio:6/4;
      box-shadow:0 8px 24px rgba(0,0,0,.08);
    }
    .poster{display:block;width:100%;height:100%;object-fit:cover;object-position:center}

    .content{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:18px}
    .title{margin:0 0 6px}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;background:#e0f2fe;border:1px solid #bae6fd;font-size:12px;margin-right:6px}

    /* --- Meta adatok (mint a sorozatoknál) --- */
    .facts{ margin:8px 0 14px; }
    .facts .badge{ margin-bottom:8px; }
    .facts-list{ list-style:none; margin:0; padding:0; }
    .facts-list li{
      display:flex; align-items:center; gap:10px;
      padding:8px 0; font-size:15px; color:#334155;
      border-bottom:1px solid #eef2f7;
    }
    .facts-list li:last-child{ border-bottom:0; }
    .facts-list i{ color:#64748b; width:18px; text-align:center; }
    .facts-list .label{ color:#64748b; width:120px; flex:0 0 auto; }
    .facts-list .value{ font-weight:600; color:#0f172a; }

    .section{margin-top:16px}
    .actors{display:flex;flex-wrap:wrap;gap:8px}
    .tag{padding:6px 10px;border-radius:999px;background:#f1f5f9;border:1px solid #e2e8f0;font-size:12px}
    .lead{background:#dcfce7;border-color:#86efac}
  </style>
</head>
<body>
  @include('partials.nav')

  <div class="container">
    <a href="{{ route('films.index') }}" class="back">← Vissza a filmekhez</a>

    <div class="wrap">
      <div class="poster-wrap">
        <img class="poster" src="{{ $film->image_url }}" alt="{{ $film->title }}">
      </div>

      <div class="content">
        <h1 class="title">{{ $film->title }}</h1>

        {{-- META BLOKK – egymás alatt, a sorozatok stílusában --}}
        <div class="facts">
          <span class="badge">{{ $film->type?->name ?? '—' }}</span>
          <ul class="facts-list">
            @if($film->release_date)
              <li>
                <i class="fa-regular fa-calendar"></i>
                <span class="label">Megjelenés</span>
                <span class="value">{{ $film->release_date->format('Y-m-d') }}</span>
              </li>
            @endif
            <li>
              <i class="fa-solid fa-user-tie"></i>
              <span class="label">Rendező</span>
              <span class="value">{{ $film->director->name }}</span>
            </li>
            @if($film->length)
              <li>
                <i class="fa-regular fa-clock"></i>
                <span class="label">Hossz</span>
                <span class="value">{{ $film->length }} perc</span>
              </li>
            @endif
          </ul>
        </div>

        @if($film->description)
          <div class="section">
            <h3>Leírás</h3>
            <p style="margin:6px 0 0">{{ $film->description }}</p>
          </div>
        @endif

        <div class="section">
          <h3>Szereplők</h3>
          @if($film->actors->count())
            <div class="actors" style="margin-top:6px">
              @foreach($film->actors as $a)
                <span class="tag {{ $a->pivot->is_lead ? 'lead' : '' }}">
                  {{ $a->name }} @if($a->pivot->is_lead) • főszerep @endif
                </span>
              @endforeach
            </div>
          @else
            <p class="meta" style="margin-top:6px;color:#64748b">Nincs megadott szereplő.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</body>
</html>
