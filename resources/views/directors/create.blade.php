<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Új rendező hozzáadása</title>
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Arial, sans-serif; background: #f7fafc; color: #0f172a; max-width: 600px; margin: 30px auto; padding: 0 20px; }
    form { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 6px 14px rgba(2,6,23,.06); }
    label { display: block; margin-bottom: 6px; font-weight: 700; }
    input[type="text"], input[type="url"] { width: 100%; padding: 8px 12px; margin-bottom: 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 16px; }
    button { background: #3b82f6; color: white; padding: 10px 18px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; }
    a { color: #3b82f6; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <h1>Új rendező hozzáadása</h1>
  <form method="POST" action="{{ route('directors.store') }}">
    @csrf

    <label for="name">Név</label>
    <input type="text" id="name" name="name" value="{{ old('name') }}" required>

    <label for="image_url">Kép URL</label>
    <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}">

    <button type="submit">Hozzáadás</button>
  </form>

  <p><a href="{{ route('directors.index') }}">← Vissza a rendezőkhöz</a></p>
</body>
</html>
