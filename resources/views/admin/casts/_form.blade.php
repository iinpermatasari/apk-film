@php($cast = $cast ?? null)

<div class="form-group">
  <label for="name">Nama Cast</label>
  <input type="text" id="name" name="name" value="{{ old('name', $cast->name ?? '') }}" maxlength="45" required>
  @error('name')<div class="error-text">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label for="age">Umur</label>
  <input type="number" id="age" name="age" value="{{ old('age', $cast->age ?? '') }}" min="0" max="150" required>
  @error('age')<div class="error-text">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label for="bio">Bio</label>
  <textarea id="bio" name="bio" required>{{ old('bio', $cast->bio ?? '') }}</textarea>
  @error('bio')<div class="error-text">{{ $message }}</div>@enderror
</div>
