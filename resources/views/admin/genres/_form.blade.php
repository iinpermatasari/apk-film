@php($genre = $genre ?? null)

<div class="form-group">
  <label for="name">Nama Genre</label>
  <input type="text" id="name" name="name" value="{{ old('name', $genre->name ?? '') }}" maxlength="45" required>
  @error('name')<div class="error-text">{{ $message }}</div>@enderror
</div>
