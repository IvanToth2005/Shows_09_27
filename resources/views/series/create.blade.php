<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Új sorozat</title>
  <style>
    :root{ --muted:#64748b; --ink:#0f172a; --ring:0 0 0 3px rgba(96,165,250,.35); }
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Arial,sans-serif;background:#f7fafc;color:var(--ink)}
    .container{max-width:960px;margin:24px auto;padding:0 16px}
    .card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:18px;box-shadow:0 6px 14px rgba(2,6,23,.06)}
    h1{margin:0 0 12px}
    .grid{display:grid;grid-template-columns:1fr 340px;gap:18px}
    @media(max-width:960px){.grid{grid-template-columns:1fr}}

    label{display:block;font-weight:600;margin:12px 0 6px}
    input[type="text"], input[type="date"], input[type="number"], select, textarea{
      width:100%; border:1px solid #e2e8f0; border-radius:12px; padding:10px 12px; font:inherit; background:#fff;
    }
    input:focus, select:focus, textarea:focus{outline:none; box-shadow:var(--ring); border-color:#93c5fd}
    textarea{min-height:120px; resize:vertical}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .actions{display:flex;gap:10px;margin-top:16px}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:12px;border:1px solid transparent;text-decoration:none;cursor:pointer}
    .btn.primary{background:#0ea5e9;color:#fff}
    .btn.secondary{background:#fff;border-color:#e2e8f0;color:#0f172a}
    .meta{color:var(--muted);font-size:14px}

    .poster-wrap{border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;aspect-ratio:2/3;background:#f1f5f9}
    .poster{width:100%;height:100%;object-fit:cover}
    .help{font-size:12px;color:#64748b;margin-top:4px}
    .flash{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;padding:10px 12px;border-radius:10px;margin:8px 0}
  </style>
</head>
<body>
  

  <div class="container">
    <a href="{{ route('series.index') }}" class="meta">← Vissza a sorozatokhoz</a>
    <h1>Új sorozat</h1>

    <form method="POST" action="{{ route('series.store') }}">
      @csrf

      <div class="grid">
        <div class="card">
          <label for="title">Cím</label>
          <input id="title" type="text" name="title" value="{{ old('title') }}" required>

          <div class="row">
            <div>
              <label for="director_id">Rendező</label>
              <select id="director_id" name="director_id" required>
                <option value="" disabled selected>Válassz…</option>
                @foreach($directors as $d)
                  <option value="{{ $d->id }}" @selected(old('director_id')==$d->id)>{{ $d->name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="type_id">Típus</label>
              <select id="type_id" name="type_id" required>
                <option value="" disabled selected>Válassz…</option>
                @foreach($types as $t)
                  <option value="{{ $t->id }}" @selected(old('type_id')==$t->id)>{{ $t->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row">
            <div>
              <label for="release_date">Premier dátum</label>
              <input id="release_date" type="date" name="release_date" value="{{ old('release_date') }}">
            </div>
            <div>
                <label for="seasons">Évadok száma</label>
                <input id="seasons" type="number" name="seasons" min="1" step="1" value="{{ old('seasons') }}">
            </div>
            <div>
              <label for="length">Epizód hossza (perc)</label>
              <input id="length" type="number" name="length" min="1" step="1" value="{{ old('length') }}">
            </div>
          </div>

          <label for="image">Kép útvonal</label>
          <input id="image" type="text" name="image" placeholder="pl. img/interstellar.jpg" value="{{ old('image') }}">
        

          <label for="description">Leírás</label>
          <textarea id="description" name="description">{{ old('description') }}</textarea>

          <div class="actions">
            <button type="submit" class="btn primary"><i class="fas fa-plus-circle"></i> Hozzáadás</button>
            <a class="btn secondary" href="{{ route('series.index') }}">Mégse</a>
          </div>

          @if ($errors->any())
            <div class="help" style="color:#b91c1c;margin-top:10px">
              <strong>Hiba:</strong>
              <ul style="margin:6px 0 0; padding-left:18px">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>

        <div class="card">
          <p class="meta" style="margin:0 0 8px">Előnézet</p>
          @php
            $img = old('image');
            $imgUrl = $img ? (preg_match('#^https?://#',$img) ? $img : asset($img))
                           : 'https://placehold.co/800x1200?text=Új%20sorozat';
          @endphp
          <div class="poster-wrap">
            <img class="poster" src="{{ $imgUrl }}" alt="Előnézet">
          </div>
          <p class="help">Mentés után a részletező oldalon is frissül a kép.</p>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
