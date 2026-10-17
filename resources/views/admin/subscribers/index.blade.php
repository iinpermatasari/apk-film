@extends('admin.layouts.app')

@section('title', 'Subscribers')
@section('heading', 'Subscriber Newsletter')

@section('content')
  <div class="page-head">
    <div>
      <strong>{{ $subscribers->total() }} subscriber</strong>
      <p>Email yang mendaftar melalui form "Subscribe to us" di footer.</p>
    </div>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:70px;">#</th>
          <th>Email</th>
          <th style="width:200px;">Tanggal Daftar</th>
          <th style="width:110px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($subscribers as $subscriber)
          <tr>
            <td class="muted">{{ $subscriber->id }}</td>
            <td>{{ $subscriber->email }}</td>
            <td class="muted">{{ $subscriber->created_at?->format('d M Y H:i') }}</td>
            <td class="actions">
              <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="post" onsubmit="return confirm('Hapus subscriber ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="empty">Belum ada subscriber.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @include('admin.partials.pagination', ['paginator' => $subscribers])
@endsection
