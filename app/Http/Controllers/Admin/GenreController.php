<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GenreController extends Controller
{
    /**
     * Daftar genre.
     */
    public function index()
    {
        $genres = Genre::withCount('films')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Form tambah genre.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Simpan genre baru.
     */
    public function store(Request $request)
    {
        Genre::create($this->validatedData($request));

        return redirect()
            ->route('admin.genres.index')
            ->with('success', 'Genre berhasil ditambahkan.');
    }

    /**
     * Form edit genre.
     */
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Perbarui genre.
     */
    public function update(Request $request, Genre $genre)
    {
        $genre->update($this->validatedData($request, $genre));

        return redirect()
            ->route('admin.genres.index')
            ->with('success', 'Genre berhasil diperbarui.');
    }

    /**
     * Hapus genre (ditolak bila masih dipakai film).
     */
    public function destroy(Genre $genre)
    {
        if ($genre->films()->exists()) {
            return back()->with('error', 'Genre tidak dapat dihapus karena masih dipakai oleh '.$genre->films()->count().' film.');
        }

        $genre->delete();

        return redirect()
            ->route('admin.genres.index')
            ->with('success', 'Genre berhasil dihapus.');
    }

    /**
     * Validasi input genre.
     *
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Genre $genre = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:45',
                Rule::unique('genres', 'name')->ignore($genre?->id),
            ],
        ]);
    }
}
