@extends('templates.index')

@section('content')
<div class="container" style="margin: 30px auto;">
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li class="active">Profil</li>
    </ol>
  </div>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>Info Akun</strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped" style="margin-bottom:0;">
            <tr><th style="width:35%;">Username</th><td>{{ auth()->user()->name }}</td></tr>
            <tr><th>Email</th><td>{{ auth()->user()->email }}</td></tr>
            <tr><th>Umur</th><td>{{ $profile->umur ?: '-' }}</td></tr>
            <tr><th>Bio</th><td>{{ $profile->bio ?: '-' }}</td></tr>
            <tr><th>Alamat</th><td>{{ $profile->alamat ?: '-' }}</td></tr>
            <tr><th>Phone</th><td>{{ $profile->phone ?: '-' }}</td></tr>
          </table>
        </div>
        <div class="panel-footer text-right">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
            Edit Profil
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="editProfileForm" action="{{ route('profile.update') }}" method="post">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="editProfileModalLabel">Edit Profil</h4>
        </div>
        <div class="modal-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul style="margin:0;">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="form-group">
            <label>Umur</label>
            <input type="number" name="umur" class="form-control" value="{{ old('umur', $profile->umur) }}" required>
          </div>
          <div class="form-group">
            <label>Bio</label>
            <textarea name="bio" class="form-control" rows="4" placeholder="Ceritakan tentang kamu" required>{{ old('bio', $profile->bio) }}</textarea>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $profile->alamat) }}</textarea>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Profil</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if ($errors->any())
  <script>
    $(function () { $('#editProfileModal').modal('show'); });
  </script>
@endif
@endsection
