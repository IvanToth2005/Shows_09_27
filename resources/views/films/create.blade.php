<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Új film hozzáadása</title>
  <style>
    body{font-family:sans-serif; background:#f9fafb; color:#0f172a; margin:20px;}
    .container{max-width:600px;margin:0 auto;}
    label{display:block;margin-top:12px;font-weight:bold;}
    input, select, textarea{width:100%;padding:8px;border:1px solid #cbd5e1;border-radius:6px;margin-top:4px;}
    button{margin-top:16px;padding:10px 16px;background:#2563eb;color:#fff;border:0;border-radius:8px;cursor:pointer;}
    button:hover{background:#1d4ed8;}
  </style>
</head>
<body>
  <div class="container">
    <h1>Új film hozzáadása</h1>
 
    @if ($errors->any())
      <div style="background:#fee2e2;color:#991b1b;padding:10px;border-radius:6px;margin-bottom:12px;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
 
    <form action="{{ route('films.store') }}" method="POST">
      @csrf
 
      <label for="title">Cím</label>
      <input type="text" name="title" id="title" value="{{ old('title') }}" required>
 
      <label for="director_id">Rendező</label>
      <select name="director_id" id="director_id" required>
        @foreach($directors as $d)
          <option value="{{ $d->id }}" @selected(old('director_id')==$d->id)>
            {{ $d->name }}
          </option>
        @endforeach
      </select>
 
      <label for="release_date">Megjelenés dátuma</label>
      <input type="date" name="release_date" id="release_date" value="{{ old('release_date') }}">
 
      <label for="type_id">Típus / műfaj</label>
      <select name="type_id" id="type_id">
        <option value="">—</option>
        @foreach($types as $t)
          <option value="{{ $t->id }}" @selected(old('type_id')==$t->id)>
            {{ $t->name }}
          </option>
        @endforeach
      </select>
 
      <label for="length">Hossz (perc)</label>
      <input type="number" name="length" id="length" value="{{ old('length') }}">
 
      <label for="description">Leírás</label>
      <textarea name="description" id="description">{{ old('description') }}</textarea>
 
      <button type="submit">Mentés</button>
    </form>
  </div>
</body>
</html>