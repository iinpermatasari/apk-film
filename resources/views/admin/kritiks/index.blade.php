@extends('admin.layouts.app')

@section('title', 'Reviews')
@section('heading', 'Moderasi Ulasan (Kritiks)')

@section('content')
  <div class="page-head">
    <div>
      <strong>{{ $kritiks->total() }} ulasan</strong>
      <p>Lihat dan hapus ulasan yang tidak pantas.</p>
    </div>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:70px;">#</th>
          <th style="width:150px;">User</th>
          <th style="width:180px;">Film</th>
          <th style="width:110px;">Rating</th>
          <th>Komentar</th>
          <th style="width:140px;">Tanggal</th>
          <th style="width:110px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($kritiks as $kritik)
          <tr>
            <td class="muted">{{ $kritik->id }}</td>
            <td>{{ $kritik->user->name ?? 'Anonim' }}</td>
            <td class="muted">{{ $kritik->film->title ?? '-' }}</td>
            <td>
              <span class="stars">
                @for ($i = 1; $i <= 5; $i++)
                  <i class="fa fa-star {{ $i <= $kritik->rating ? '' : 'off' }}"></i>
                @endfor
              </span>
            </td>
            <td class="comment-cell">{{ $kritik->comment }}</td>
            <td class="muted">{{ $kritik->created_at?->format('d M Y H:i') }}</td>
            <td class="actions">
              <form action="{{ route('admin.kritiks.destroy', $kritik) }}" method="post" onsubmit="return confirm('Hapus ulasan ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="empty">Belum ada ulasan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @include('admin.partials.pagination', ['paginator' => $kritiks])
@endsection
