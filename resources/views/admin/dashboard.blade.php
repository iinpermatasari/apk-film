@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
  <div class="cards">
    <div class="stat-card">
      <div class="icon bg-blue"><i class="fa fa-video-camera"></i></div>
      <div>
        <div class="value">{{ number_format($stats['films']) }}</div>
        <div class="label">Total Film</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon bg-green"><i class="fa fa-user"></i></div>
      <div>
        <div class="value">{{ number_format($stats['users']) }}</div>
        <div class="label">Total User</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon bg-orange"><i class="fa fa-comments"></i></div>
      <div>
        <div class="value">{{ number_format($stats['kritiks']) }}</div>
        <div class="label">Total Ulasan</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon bg-purple"><i class="fa fa-tags"></i></div>
      <div>
        <div class="value">{{ number_format($stats['genres']) }}</div>
        <div class="label">Total Genre</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon bg-pink"><i class="fa fa-users"></i></div>
      <div>
        <div class="value">{{ number_format($stats['casts']) }}</div>
        <div class="label">Total Cast</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="icon bg-teal"><i class="fa fa-envelope"></i></div>
      <div>
        <div class="value">{{ number_format($stats['subscribers']) }}</div>
        <div class="label">Subscriber</div>
      </div>
    </div>
  </div>

  <div class="panels">
    <div class="panel">
      <div class="panel-head">
        <span><i class="fa fa-video-camera"></i> Film Terbaru</span>
        <a class="btn btn-sm btn-secondary" href="{{ route('admin.films.index') }}">Lihat semua</a>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr><th>Judul</th><th>Genre</th><th>Tahun</th></tr>
          </thead>
          <tbody>
            @forelse ($latestFilms as $film)
              <tr>
                <td>{{ $film->title }}</td>
                <td class="muted">{{ $film->genre->name ?? '-' }}</td>
                <td>{{ $film->year }}</td>
              </tr>
            @empty
              <tr><td colspan="3" class="empty">Belum ada film.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <span><i class="fa fa-comments"></i> Ulasan Terbaru</span>
        <a class="btn btn-sm btn-secondary" href="{{ route('admin.kritiks.index') }}">Moderasi</a>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr><th>User</th><th>Film</th><th>Rating</th></tr>
          </thead>
          <tbody>
            @forelse ($latestKritiks as $kritik)
              <tr>
                <td>{{ $kritik->user->name ?? 'Anonim' }}</td>
                <td class="muted">{{ $kritik->film->title ?? '-' }}</td>
                <td>
                  <span class="stars">
                    @for ($i = 1; $i <= 5; $i++)
                      <i class="fa fa-star {{ $i <= $kritik->rating ? '' : 'off' }}"></i>
                    @endfor
                  </span>
                </td>
              </tr>
            @empty
              <tr><td colspan="3" class="empty">Belum ada ulasan.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
