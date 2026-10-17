@extends('admin.layouts.app')

@section('title', 'Edit Genre')
@section('heading', 'Edit Genre')

@section('content')
  <div class="form-card">
    <form action="{{ route('admin.genres.update', $genre) }}" method="post">
      @csrf
      @method('PUT')
      @include('admin.genres._form')

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Perbarui</button>
        <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
