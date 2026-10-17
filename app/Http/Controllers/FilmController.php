<?php

namespace App\Http\Controllers;

use App\Models\{
    Film,
    Genre,
    Kritik,
    Peran,
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Daftar film beserta pencarian.
     */
    public function movies(Request $request)
    {
        $genreFilm = null;
        $search = trim((string) $request->query('search'));

        $films = Film::select('id', 'title', 'poster', 'year')
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', '%'.$search.'%')
                          ->orWhere('sinopsis', 'like', '%'.$search.'%');
                    });
                })
                ->orderByDesc('year')
                ->orderBy('created_at', 'asc')
                ->paginate(18)
                ->withQueryString();

        return view('components/movies', compact('films', 'genreFilm'));
    }

    /**
     * Detail satu film beserta pemeran dan ulasannya.
     */
    public function show(Film $film)
    {
        $filmByGenre = Film::select('id', 'title', 'poster', 'year', 'sinopsis')
                        ->where('genre_id', '=', $film->genre_id)
                        ->orderBy('created_at', 'asc')
                        ->limit(7)
                        ->get();
        $filmByRelease = Film::select('id', 'title', 'poster', 'year')
                        ->where('year', '=', Carbon::now()->format('Y'))
                        ->orderBy('created_at', 'asc')
                        ->limit(9)
                        ->get();
        $comments = Kritik::with('user')
                        ->select('id', 'comment', 'rating', 'user_id', 'film_id', 'created_at')
                        ->where('film_id', '=', $film->id)
                        ->orderByDesc('created_at')
                        ->get();
        $perans = Peran::with('cast')
                        ->where('film_id', '=', $film->id)
                        ->get();

        return view('components.movie-show', compact('film', 'filmByGenre', 'filmByRelease', 'comments', 'perans'));
    }

    /**
     * Halaman utama.
     */
    public function movieHome()
    {
        $films = Film::select('id', 'title', 'poster', 'year')
                ->orderBy('created_at', 'asc')
                ->limit(9)->get();
        $filmFutured = Film::select('id', 'title', 'poster', 'year')
                        ->orderByDesc('year')
                        ->orderBy('created_at', 'asc')
                        ->limit(6)->get();
        $filmRecentAdded = Film::select('id', 'title', 'poster', 'year')
                            ->orderByDesc('created_at')
                            ->limit(6)->get();
        $filmSlidey = Film::select('title', 'poster', 'sinopsis')
                        ->orderByDesc('year')
                        ->orderBy('created_at', 'asc')
                        ->limit(6)->get();

        return view('components/home', compact('filmSlidey', 'films', 'filmFutured', 'filmRecentAdded'));
    }

    /**
     * Daftar film berdasarkan genre.
     */
    public function moviesByGenre($genre)
    {
        $genreFilm = Genre::where('id', '=', $genre)->first();
        $films = Film::select('id', 'title', 'poster', 'year')
                ->where('genre_id', '=', $genre)
                ->orderByDesc('year')
                ->orderBy('created_at', 'asc')
                ->paginate(18);

        return view('components/movies', compact('films', 'genreFilm'));
    }
}
