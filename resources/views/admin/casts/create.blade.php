@extends('admin.layouts.app')

@section('title', 'Tambah Cast')
@section('heading', 'Tambah Cast')

@section('content')
  <div class="form-card">
    <form action="{{ route('admin.casts.store') }}" method="post">
      @csrf
      @include('admin.casts._form')

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        <a href="{{ route('admin.casts.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
