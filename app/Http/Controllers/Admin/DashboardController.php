<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\Subscriber;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman statistik utama dashboard admin.
     */
    public function index()
    {
        $stats = [
            'films' => Film::count(),
            'genres' => Genre::count(),
            'casts' => Cast::count(),
            'users' => User::count(),
            'kritiks' => Kritik::count(),
            'subscribers' => Subscriber::count(),
        ];

        $latestFilms = Film::with('genre')->latest()->take(5)->get();

        $latestKritiks = Kritik::with(['user', 'film'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestFilms', 'latestKritiks'));
    }
}
