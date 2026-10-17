<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;

class CastController extends Controller
{
    /**
     * Daftar cast.
     */
    public function index()
    {
        $casts = Cast::withCount('perans')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.casts.index', compact('casts'));
    }

    /**
     * Form tambah cast.
     */
    public function create()
    {
        return view('admin.casts.create');
    }

    /**
     * Simpan cast baru.
     */
    public function store(Request $request)
    {
        Cast::create($this->validatedData($request));

        return redirect()
            ->route('admin.casts.index')
            ->with('success', 'Cast berhasil ditambahkan.');
    }

    /**
     * Form edit cast.
     */
    public function edit(Cast $cast)
    {
        return view('admin.casts.edit', compact('cast'));
    }

    /**
     * Perbarui cast.
     */
    public function update(Request $request, Cast $cast)
    {
        $cast->update($this->validatedData($request));

        return redirect()
            ->route('admin.casts.index')
            ->with('success', 'Cast berhasil diperbarui.');
    }

    /**
     * Hapus cast (ditolak bila masih terhubung ke film).
     */
    public function destroy(Cast $cast)
    {
        if ($cast->perans()->exists()) {
            return back()->with('error', 'Cast tidak dapat dihapus karena masih terhubung ke '.$cast->perans()->count().' peran film.');
        }

        $cast->delete();

        return redirect()
            ->route('admin.casts.index')
            ->with('success', 'Cast berhasil dihapus.');
    }

    /**
     * Validasi input cast.
     *
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'age' => ['required', 'integer', 'min:0', 'max:150'],
            'bio' => ['required', 'string'],
        ]);
    }
}
