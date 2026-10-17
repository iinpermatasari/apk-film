@extends('admin.layouts.app')

@section('title', 'Tambah Film')
@section('heading', 'Tambah Film')

@section('content')
  <div class="form-card">
    <form action="{{ route('admin.films.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      @include('admin.films._form')

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        <a href="{{ route('admin.films.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
