<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Kritik;
use App\Http\Requests\StoreKritikRequest;
use App\Http\Requests\UpdateKritikRequest;

class KritikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created comment for a film.
     */
    public function store(StoreKritikRequest $request, Film $film)
    {
        $film->kritiks()->create([
            'comment' => $request->validated('comment'),
            'rating' => $request->validated('rating'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('movies.show', $film->id)
            ->with('success', 'Komentar berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kritik $kritik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kritik $kritik)
    {
        //
    }

    /**
     * Update the specified comment (owner only).
     */
    public function update(UpdateKritikRequest $request, Kritik $kritik)
    {
        $kritik->update($request->validated());

        return redirect()->route('movies.show', $kritik->film_id)
            ->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Remove the specified comment (owner only).
     */
    public function destroy(Kritik $kritik)
    {
        abort_unless($kritik->user_id === auth()->id(), 403);

        $filmId = $kritik->film_id;
        $kritik->delete();

        return redirect()->route('movies.show', $filmId)
            ->with('success', 'Komentar berhasil dihapus.');
    }
}
