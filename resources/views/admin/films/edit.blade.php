@extends('admin.layouts.app')

@section('title', 'Edit Film')
@section('heading', 'Edit Film')

@section('content')
  <div class="form-card">
    <form action="{{ route('admin.films.update', $film) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('admin.films._form')

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Perbarui</button>
        <a href="{{ route('admin.films.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
