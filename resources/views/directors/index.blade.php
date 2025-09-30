<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Színészek</title>
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" />
  <style>
    :root {
      --ink: #0f172a;
      --muted: #64748b;
      --ring: 0 0 0 3px rgba(96, 165, 250, 0.35);
      --accent: #60a5fa;
    }
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu,
        Cantarell, Arial, sans-serif;
      background: #f7fafc;
      color: var(--ink);
    }
    .container {
      max-width: 1120px;
      margin: 28px auto;
      padding: 0 16px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 18px;
    }
    @media (max-width: 900px) {
      .grid {
        grid-template-columns: 1fr;
      }
    }

    .card {
      position: relative;
      background: #fff;
      border: 1px solid rgba(2, 6, 23, 0.08);
      border-radius: 16px;
      padding: 16px;
      box-shadow: 0 6px 14px rgba(2, 6, 23, 0.06);
      display: grid;
      grid-template-columns: 96px 1fr;
      gap: 16px;
      transition: transform 0.2s ease, box-shadow 0.2s ease,
        border-color 0.2s ease;
    }
    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 36px rgba(2, 6, 23, 0.12);
      border-color: #bfdbfe;
    }
    .avatar {
      width: 96px;
      height: 96px;
      border-radius: 12px;
      object-fit: cover;
      background: #e2e8f0;
      border: 1px solid #e5e7eb;
    }
    .name {
      margin: 0 0 6px;
      font-size: 20px;
      font-weight: 800;
    }
    .meta {
      margin: 0 0 10px;
      color: var(--muted);
      font-size: 14px;
    }

    .chips {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }
    .chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 10px;
      border-radius: 999px;
      background: #f1f5f9;
      border: 1px solid #e2e8f0;
      color: #0f172a;
      font-size: 13px;
      text-decoration: none;
      transition: transform 0.15s ease, box-shadow 0.15s ease,
        border-color 0.15s ease;
    }
    .chip:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 16px rgba(2, 6, 23, 0.08);
      border-color: #cbd5e1;
    }
    .chip .badge {
      font-size: 11px;
      color: #475569;
    }

    /* külön szín film / sorozat jelöléshez */
    .chip.series {
      background: #e0f2fe;
      border-color: #bfdbfe;
    }

    /* főszerep kiemelés felülírja az alapot */
    .chip.lead {
      background: #dcfce7 !important;
      border-color: #86efac !important;
    }

    .section-title {
      font-weight: 700;
      margin: 10px 0 6px;
    }

    /* Törlés és módosítás gombok */
    .card-actions {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 4;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .icon-btn {
      width: 36px;
      height: 36px;
      border-radius: 9999px;
      display: grid;
      place-items: center;
      cursor: pointer;
      background: #fff;
      border: 2px solid #e2e8f0;
      box-shadow: 0 6px 14px rgba(2, 6, 23, 0.08);
      opacity: 0;
      transform: translateY(-6px);
      transition: 0.2s;
    }
    .card:hover .icon-btn {
      opacity: 1;
      transform: translateY(0);
    }
    .icon-btn.is-danger {
      border-color: #fecaca;
    }
    .icon-btn.is-danger:hover {
      border-color: #ef4444;
      background: #fee2e2;
      box-shadow: 0 0 0 6px rgba(239, 68, 68, 0.12),
        0 12px 24px rgba(2, 6, 23, 0.12);
    }
    .icon-btn.is-primary {
      border-color: #bfdbfe;
    }
    .icon-btn.is-primary:hover {
      border-color: #3b82f6;
      background: #dbeafe;
      box-shadow: 0 0 0 6px rgba(59, 130, 246, 0.12),
        0 12px 24px rgba(2, 6, 23, 0.12);
    }
    .icon-btn .fa-trash {
      color: #ef4444;
      font-size: 16px;
    }
    .icon-btn .fa-edit {
      color: #2563eb;
      font-size: 16px;
    }
  </style>
</head>
<body>
  @include('partials.nav')

  <div class="container">
    <h1
      style="
        margin: 0 0 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
      "
    >
      Rendezők
      <a
        href="{{ route('directors.create') }}"
        style="
          background: #3b82f6;
          color: white;
          padding: 8px 16px;
          border-radius: 8px;
          text-decoration: none;
          font-weight: 600;
          font-size: 14px;
        "
      >
        <i class="fas fa-plus" style="margin-right: 6px"></i> Új rendező hozzáadása
      </a>
    </h1>
    <p class="meta" style="margin: 0 0 16px">
      Kattints egy film vagy sorozat címkére a részletekhez.
    </p>

    <section class="grid">
      @forelse($directors as $director)
      <article class="card">
        <img class="avatar" src="{{ $director->image_url }}" alt="{{ $director->name }}" />

        <div>
          @php
          $filmCount = $director->films->count();
          $seriesCount = $director->series->count();
          @endphp

          <h3 class="name">{{ $director->name }}</h3>
          <p class="meta">
            Filmek: {{ $filmCount }}
            @if($seriesCount) • Sorozatok: {{ $seriesCount }} @endif
          </p>

          @if($filmCount || $seriesCount)

          @else
          <p class="meta">Nincs hozzárendelt film/sorozat.</p>
          @endif
        </div>

        <!-- Törlés és módosítás gombok -->
        <div class="card-actions" aria-label="Színész műveletek">
          <form
            method="POST"
            action="{{ route('directors.destroy', $director) }}"
            onsubmit="return confirm('Biztosan törlöd: {{ addslashes($director->name) }}?')"
            style="margin: 0"
          >
            @csrf
            @method('DELETE')
            <button
              type="submit"
              class="icon-btn is-danger"
              title="Törlés"
              aria-label="Törlés"
            >
              <i class="fa-solid fa-trash"></i>
            </button>
          </form>
          <a
            href="{{ route('directors.edit', $director) }}"
            class="icon-btn is-primary"
            title="Módosítás"
            aria-label="Módosítás"
          >
            <i class="fas fa-edit"></i>
          </a>
        </div>
      </article>
      @empty
      <p>Nincs még rendező az adatbázisban.</p>
      @endforelse
    </section>

    <div style="margin-top: 14px">{{ $directors->links() }}</div>
  </div>
</body>
</html>
