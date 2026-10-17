<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    /**
     * Daftar film.
     */
    public function index()
    {
        $films = Film::with('genre')
            ->withCount('kritiks')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.films.index', compact('films'));
    }

    /**
     * Form tambah film.
     */
    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        $casts = Cast::orderBy('name')->get();

        return view('admin.films.create', compact('genres', 'casts'));
    }

    /**
     * Simpan film baru beserta pemerannya.
     */
    public function store(Request $request)
    {
        $this->normalizePerans($request);

        $data = $this->validatedData($request, isStore: true);

        DB::transaction(function () use ($request, $data) {
            $data['poster'] = $this->storePoster($request);

            $film = Film::create($data);

            $this->syncPerans($film, $request);
        });

        return redirect()
            ->route('admin.films.index')
            ->with('success', 'Film berhasil ditambahkan.');
    }

    /**
     * Form edit film.
     */
    public function edit(Film $film)
    {
        $film->load('perans');

        $genres = Genre::orderBy('name')->get();
        $casts = Cast::orderBy('name')->get();

        return view('admin.films.edit', compact('film', 'genres', 'casts'));
    }

    /**
     * Perbarui film beserta pemerannya.
     */
    public function update(Request $request, Film $film)
    {
        $this->normalizePerans($request);

        $data = $this->validatedData($request, isStore: false);

        DB::transaction(function () use ($request, $film, $data) {
            if ($request->hasFile('poster')) {
                $this->deletePosterFile($film->poster);
                $data['poster'] = $this->storePoster($request);
            }

            $film->update($data);

            $this->syncPerans($film, $request);
        });

        return redirect()
            ->route('admin.films.index')
            ->with('success', 'Film berhasil diperbarui.');
    }

    /**
     * Hapus film beserta data terkait (peran, ulasan, dan file poster).
     */
    public function destroy(Film $film)
    {
        DB::transaction(function () use ($film) {
            $film->kritiks()->delete();
            Peran::where('film_id', $film->id)->delete();
            $this->deletePosterFile($film->poster);
            $film->delete();
        });

        return redirect()
            ->route('admin.films.index')
            ->with('success', 'Film berhasil dihapus.');
    }

    /**
     * Simpan file poster ke disk "public" (folder storage/app/public/images),
     * lalu kembalikan path relatif yang dipakai di kolom poster ("storage/images/...").
     */
    private function storePoster(Request $request): string
    {
        $path = $request->file('poster')->store('images', 'public');

        return 'storage/'.$path;
    }

    /**
     * Hapus file poster lama dari disk bila ada.
     */
    private function deletePosterFile(?string $poster): void
    {
        if (blank($poster)) {
            return;
        }

        Storage::disk('public')->delete(Str::after($poster, 'storage/'));
    }

    /**
     * Sinkronkan data pemeran (perans) milik film.
     */
    private function syncPerans(Film $film, Request $request): void
    {
        $film->perans()->delete();

        foreach ($request->input('perans', []) as $row) {
            $film->perans()->create([
                'cast_id' => $row['cast_id'],
                'actor' => $row['actor'],
            ]);
        }
    }

    /**
     * Buang baris pemeran yang benar-benar kosong sebelum validasi,
     * agar baris kosong tidak memicu error "wajib diisi".
     */
    private function normalizePerans(Request $request): void
    {
        $rows = collect($request->input('perans', []))
            ->filter(fn ($row) => filled($row['cast_id'] ?? null) || filled($row['actor'] ?? null))
            ->values()
            ->all();

        $request->merge(['perans' => $rows]);
    }

    /**
     * Validasi input film.
     *
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, bool $isStore): array
    {
        $posterRules = $isStore
            ? ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']
            : ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sinopsis' => ['required', 'string'],
            'year' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 5)],
            'genre_id' => ['required', 'integer', 'exists:genres,id'],
            'poster' => $posterRules,
            'perans' => ['nullable', 'array'],
            'perans.*.cast_id' => ['required', 'integer', 'exists:casts,id'],
            'perans.*.actor' => ['required', 'string', 'max:255'],
        ], [
            'poster.max' => 'Ukuran poster maksimal 2MB.',
            'poster.mimes' => 'Format poster harus jpg, jpeg, png, atau webp.',
            'poster.image' => 'File poster harus berupa gambar.',
            'perans.*.cast_id.required' => 'Cast wajib dipilih untuk setiap baris pemeran.',
            'perans.*.cast_id.exists' => 'Cast yang dipilih tidak valid.',
            'perans.*.actor.required' => 'Nama peran wajib diisi untuk setiap baris pemeran.',
        ]);

        unset($validated['poster'], $validated['perans']);

        return $validated;
    }
}
