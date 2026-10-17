@extends('admin.layouts.app')

@section('title', 'Edit Cast')
@section('heading', 'Edit Cast')

@section('content')
  <div class="form-card">
    <form action="{{ route('admin.casts.update', $cast) }}" method="post">
      @csrf
      @method('PUT')
      @include('admin.casts._form')

      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Perbarui</button>
        <a href="{{ route('admin.casts.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
@endsection
