@extends('admin.layouts.app')

@section('title', 'Films')
@section('heading', 'Manajemen Film')

@section('content')
  <div class="page-head">
    <div>
      <strong>{{ $films->total() }} film</strong>
      <p>Kelola data film: tambah, edit, dan hapus.</p>
    </div>
    <a href="{{ route('admin.films.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Film</a>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:70px;">Poster</th>
          <th>Judul</th>
          <th>Genre</th>
          <th>Tahun</th>
          <th>Ulasan</th>
          <th style="width:150px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($films as $film)
          <tr>
            <td><img class="poster-thumb" src="{{ asset($film->poster) }}" alt="{{ $film->title }}"></td>
            <td>{{ $film->title }}</td>
            <td class="muted">{{ $film->genre->name ?? '-' }}</td>
            <td>{{ $film->year }}</td>
            <td>{{ $film->kritiks_count }}</td>
            <td class="actions">
              <a href="{{ route('admin.films.edit', $film) }}" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i> Edit</a>
              <form class="btn-inline" action="{{ route('admin.films.destroy', $film) }}" method="post" onsubmit="return confirm('Hapus film \"{{ $film->title }}\"? Semua ulasan terkait juga akan terhapus.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="empty">Belum ada film.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @include('admin.partials.pagination', ['paginator' => $films])
@endsection
