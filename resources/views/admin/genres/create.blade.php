@extends('admin.layouts.app')

@section('title', 'Tambah Genre')
@section('heading', 'Tambah Genre')

@section('content')
  <div class="form-card">
    <form action="{{ route('admin.genres.store') }}" method="post">
      @csrf
      @include('admin.genres._form')

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
