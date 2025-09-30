<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $series->title }} – szerkesztés</title>
  <style>
    :root{ --muted:#64748b; --ink:#0f172a; --ring:0 0 0 3px rgba(96,165,250,.35); }
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Arial,sans-serif;background:#f7fafc;color:var(--ink)}
    .container{max-width:960px;margin:24px auto;padding:0 16px}
    .card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:18px;box-shadow:0 6px 14px rgba(2,6,23,.06)}
    .grid{display:grid;grid-template-columns:1fr 340px;gap:18px}
    @media(max-width:960px){.grid{grid-template-columns:1fr}}
    label{display:block;font-weight:600;margin:12px 0 6px}
    input[type="text"],input[type="date"],input[type="number"],select,textarea{width:100%;border:1px solid #e2e8f0;border-radius:12px;padding:10px 12px;font:inherit;background:#fff}
    input:focus,select:focus,textarea:focus{outline:none;box-shadow:var(--ring);border-color:#93c5fd}
    textarea{min-height:120px;resize:vertical}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .actions{display:flex;gap:10px;margin-top:16px}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:12px;border:1px solid transparent;text-decoration:none;cursor:pointer}
    .btn.primary{background:#0ea5e9;color:#fff}
    .btn.secondary{background:#fff;border-color:#e2e8f0;color:#0f172a}
    .poster-wrap{border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;aspect-ratio:2/3;background:#f1f5f9}
    .poster{width:100%;height:100%;object-fit:cover}
    .meta{color:#64748b;font-size:14px}
  </style>
</head>
<body>
  @include('partials.nav')

  <div class="container">
    <a href="{{ route('series.index') }}" class="meta">← Vissza a sorozatokhoz</a>
    <h1>Sorozat szerkesztése</h1>

    <form method="POST" action="{{ route('series.update', $series) }}">
      @csrf @method('PUT')

      <div class="grid">
        <div class="card">
          <label for="title">Cím</label>
          <input id="title" type="text" name="title" value="{{ old('title', $series->title) }}" required>

          <div class="row">
            <div>
              <label for="director_id">Rendező</label>
              <select id="director_id" name="director_id" required>
                @foreach($directors as $d)
                  <option value="{{ $d->id }}" @selected(old('director_id',$series->director_id)===$d->id)>{{ $d->name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="type_id">Típus</label>
              <select id="type_id" name="type_id" required>
                @foreach($types as $t)
                  <option value="{{ $t->id }}" @selected(old('type_id',$series->type_id)===$t->id)>{{ $t->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row">
            <div>
              <label for="seasons">Évadok száma</label>
              <input id="seasons" type="number" name="seasons" min="1" step="1" value="{{ old('seasons', $series->seasons) }}">
            </div>
            <div>
              <label for="release_date">Premier dátum (opcionális)</label>
              <input id="release_date" type="date" name="release_date" value="{{ old('release_date', $series->release_date?->format('Y-m-d')) }}">
            </div>
          </div>

          <div class="row">
            <div>
              <label for="length">Epizód hossza (perc)</label>
              <input id="length" type="number" name="length" min="1" step="1" value="{{ old('length', $series->length) }}">
            </div>
            <div>
              <label for="image">Kép útvonal</label>
              <input id="image" type="text" name="image" placeholder="pl. img/series/dune.jpg" value="{{ old('image', $series->image) }}">
            </div>
          </div>
          <label>Színészek</label>
          <div style="display:flex;flex-direction:column;gap:10px;border:1px solid #e2e8f0;border-radius:12px;padding:12px;max-height:300px;overflow:auto">
            @foreach($actors as $actor)
              @php
                $selected = old('actors', $series->actors->pluck('id')->toArray());
                $isSelected = in_array($actor->id, $selected);

                $pivotData = $series->actors->firstWhere('id', $actor->id)?->pivot;
                $isLead = old("is_lead.{$actor->id}", $pivotData?->is_lead);
              @endphp
              <div style="display:flex;align-items:center;justify-content:space-between;">
                <label style="display:flex;align-items:center;gap:10px">
                  <input type="checkbox" name="actors[]" value="{{ $actor->id }}" {{ $isSelected ? 'checked' : '' }}>
                  {{ $actor->name }}
                </label>

                <label style="display:flex;align-items:center;gap:4px;font-size:13px;color:#475569">
                  <input type="checkbox" name="is_lead[{{ $actor->id }}]" value="1" {{ $isLead ? 'checked' : '' }}>
                  főszerep
                </label>
              </div>
            @endforeach
          </div>
          <p class="help">Jelöld ki a színészeket, és ha főszereplő, pipáld be a "főszerep" mezőt.</p>
          <label for="description">Leírás</label>
          <textarea id="description" name="description">{{ old('description', $series->description) }}</textarea>

          <div class="actions">
            <button type="submit" class="btn primary"><i class="fas fa-save"></i> Mentés</button>
            <a class="btn secondary" href="{{ route('series.show', $series) }}">Mégse</a>
          </div>

          @if ($errors->any())
            <div class="meta" style="color:#b91c1c;margin-top:10px">
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
          <div class="poster-wrap">
            <img class="poster" src="{{ $series->image_url }}" alt="Előnézet">
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
