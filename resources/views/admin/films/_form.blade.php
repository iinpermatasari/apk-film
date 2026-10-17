@php
  $film = $film ?? null;

  $peranRows = old('perans', $film
      ? $film->perans->map(fn ($p) => ['cast_id' => $p->cast_id, 'actor' => $p->actor])->all()
      : []);

  if (empty($peranRows)) {
      $peranRows = [['cast_id' => '', 'actor' => '']];
  }
@endphp

<div class="form-group">
  <label for="title">Judul Film</label>
  <input type="text" id="title" name="title" value="{{ old('title', $film->title ?? '') }}" required>
  @error('title')<div class="error-text">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label for="genre_id">Genre</label>
  <select id="genre_id" name="genre_id" required>
    <option value="">-- Pilih Genre --</option>
    @foreach ($genres as $genre)
      <option value="{{ $genre->id }}" @selected(old('genre_id', $film->genre_id ?? '') == $genre->id)>{{ $genre->name }}</option>
    @endforeach
  </select>
  @error('genre_id')<div class="error-text">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label for="year">Tahun Rilis</label>
  <input type="number" id="year" name="year" value="{{ old('year', $film->year ?? date('Y')) }}" min="1900" max="{{ date('Y') + 5 }}" required>
  @error('year')<div class="error-text">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label for="poster">Poster Film</label>

  @if ($film && $film->poster)
    <div class="poster-current">
      <img src="{{ asset($film->poster) }}" alt="Poster {{ $film->title }}">
      <span class="hint">Poster saat ini. Pilih file baru untuk menggantinya.</span>
    </div>
  @endif

  <input type="file" id="poster" name="poster" accept="image/jpeg,image/png,image/webp" {{ $film ? '' : 'required' }}>
  <div class="hint">
    Format: <strong>jpg, jpeg, png, webp</strong>. Maksimal <strong>2MB</strong>.
    @unless ($film) Wajib diunggah. @endunless
  </div>
  @error('poster')<div class="error-text">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label>Sinopsis</label>
  <textarea id="sinopsis" name="sinopsis" required>{{ old('sinopsis', $film->sinopsis ?? '') }}</textarea>
  @error('sinopsis')<div class="error-text">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label>Pemeran (Cast) &amp; Peran</label>
  <div class="hint" style="margin-top:0; margin-bottom:10px;">Pilih aktor dari daftar Cast, lalu tuliskan nama perannya di film ini.</div>

  <div id="peran-rows">
    @foreach ($peranRows as $i => $row)
      <div class="peran-row">
        <select name="perans[{{ $i }}][cast_id]">
          <option value="">-- Pilih Cast --</option>
          @foreach ($casts as $castOption)
            <option value="{{ $castOption->id }}" @selected(($row['cast_id'] ?? '') == $castOption->id)>{{ $castOption->name }}</option>
          @endforeach
        </select>
        <input type="text" name="perans[{{ $i }}][actor]" value="{{ $row['actor'] ?? '' }}" placeholder="Nama peran (character)">
        <button type="button" class="btn btn-sm btn-danger peran-remove" title="Hapus baris"><i class="fa fa-times"></i></button>
      </div>
    @endforeach
  </div>

  <button type="button" class="btn btn-sm btn-secondary" id="peran-add"><i class="fa fa-plus"></i> Tambah Pemeran</button>

  @error('perans.*.cast_id')<div class="error-text">{{ $message }}</div>@enderror
  @error('perans.*.actor')<div class="error-text">{{ $message }}</div>@enderror
</div>

<template id="peran-row-tpl">
  <div class="peran-row">
    <select name="perans[__INDEX__][cast_id]">
      <option value="">-- Pilih Cast --</option>
      @foreach ($casts as $castOption)
        <option value="{{ $castOption->id }}">{{ $castOption->name }}</option>
      @endforeach
    </select>
    <input type="text" name="perans[__INDEX__][actor]" placeholder="Nama peran (character)">
    <button type="button" class="btn btn-sm btn-danger peran-remove" title="Hapus baris"><i class="fa fa-times"></i></button>
  </div>
</template>

@push('style')
<style>
  .poster-current { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
  .poster-current img { width: 70px; height: 96px; object-fit: cover; border-radius: 6px; border: 1px solid #d7dee8; }
  .peran-row { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; }
  .peran-row select { flex: 2; }
  .peran-row input { flex: 3; }
  .peran-row .peran-remove { flex: 0 0 auto; }
  input[type=file] { padding: 8px; background: #fafbfd; border: 1px dashed #c3ccda; border-radius: 6px; width: 100%; }
</style>
@endpush

@push('script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var wrap = document.getElementById('peran-rows');
    var tpl = document.getElementById('peran-row-tpl');
    var addBtn = document.getElementById('peran-add');
    if (!wrap || !tpl || !addBtn) return;

    var nextIndex = wrap.querySelectorAll('.peran-row').length;

    addBtn.addEventListener('click', function () {
      wrap.insertAdjacentHTML('beforeend', tpl.innerHTML.split('__INDEX__').join(nextIndex++));
    });

    wrap.addEventListener('click', function (e) {
      var btn = e.target.closest('.peran-remove');
      if (btn) {
        btn.closest('.peran-row').remove();
      }
    });
  });
</script>
@endpush
