@extends('admin.layouts.app')

@section('title', 'Genres')
@section('heading', 'Manajemen Genre')

@section('content')
  <div class="page-head">
    <div>
      <strong>{{ $genres->total() }} genre</strong>
      <p>Kelola kategori genre film.</p>
    </div>
    <a href="{{ route('admin.genres.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Genre</a>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:70px;">#</th>
          <th>Nama Genre</th>
          <th>Jumlah Film</th>
          <th style="width:150px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($genres as $genre)
          <tr>
            <td class="muted">{{ $genre->id }}</td>
            <td>{{ $genre->name }}</td>
            <td>{{ $genre->films_count }}</td>
            <td class="actions">
              <a href="{{ route('admin.genres.edit', $genre) }}" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i> Edit</a>
              <form class="btn-inline" action="{{ route('admin.genres.destroy', $genre) }}" method="post" onsubmit="return confirm('Hapus genre {{ $genre->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="empty">Belum ada genre.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @include('admin.partials.pagination', ['paginator' => $genres])
@endsection
