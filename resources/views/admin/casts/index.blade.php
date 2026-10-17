@extends('admin.layouts.app')

@section('title', 'Casts')
@section('heading', 'Manajemen Cast')

@section('content')
  <div class="page-head">
    <div>
      <strong>{{ $casts->total() }} cast</strong>
      <p>Kelola data aktor/aktris.</p>
    </div>
    <a href="{{ route('admin.casts.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Cast</a>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:70px;">#</th>
          <th>Nama</th>
          <th style="width:90px;">Umur</th>
          <th>Bio</th>
          <th style="width:90px;">Peran</th>
          <th style="width:150px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($casts as $cast)
          <tr>
            <td class="muted">{{ $cast->id }}</td>
            <td>{{ $cast->name }}</td>
            <td>{{ $cast->age }}</td>
            <td class="comment-cell muted">{{ \Illuminate\Support\Str::limit($cast->bio, 80) }}</td>
            <td>{{ $cast->perans_count }}</td>
            <td class="actions">
              <a href="{{ route('admin.casts.edit', $cast) }}" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i> Edit</a>
              <form class="btn-inline" action="{{ route('admin.casts.destroy', $cast) }}" method="post" onsubmit="return confirm('Hapus cast {{ $cast->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="empty">Belum ada cast.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @include('admin.partials.pagination', ['paginator' => $casts])
@endsection
