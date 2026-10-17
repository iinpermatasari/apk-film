@extends('admin.layouts.app')

@section('title', 'Users')
@section('heading', 'Daftar User')

@section('content')
  <div class="page-head">
    <div>
      <strong>{{ $users->total() }} user</strong>
      <p>Daftar akun yang terdaftar beserta rolenya.</p>
    </div>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:70px;">#</th>
          <th>Nama</th>
          <th>Email</th>
          <th style="width:110px;">Role</th>
          <th style="width:90px;">Ulasan</th>
          <th style="width:150px;">Terdaftar</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr>
            <td class="muted">{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td class="muted">{{ $user->email }}</td>
            <td>
              @if ($user->isAdmin())
                <span class="badge badge-admin">Admin</span>
              @else
                <span class="badge badge-user">{{ $user->role->name ?? 'user' }}</span>
              @endif
            </td>
            <td>{{ $user->kritiks_count }}</td>
            <td class="muted">{{ $user->created_at?->format('d M Y') }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="empty">Belum ada user.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @include('admin.partials.pagination', ['paginator' => $users])
@endsection
