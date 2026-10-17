<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    FilmController,
    KritikController,
    ProfileController,
    SubscriberController,
};
use App\Http\Controllers\Admin\{
    CastController as AdminCastController,
    DashboardController as AdminDashboardController,
    FilmController as AdminFilmController,
    GenreController as AdminGenreController,
    KritikController as AdminKritikController,
    SubscriberController as AdminSubscriberController,
    UserController as AdminUserController,
};

Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');

// Route dengan nama "login" dipakai middleware "auth" untuk redirect guest.
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/movies/{film}/comments', [KritikController::class, 'store'])->name('comments.store');
    Route::put('/comments/{kritik}', [KritikController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{kritik}', [KritikController::class, 'destroy'])->name('comments.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
| Dilindungi middleware "auth" (harus login) dan "admin" (harus role admin).
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('films', AdminFilmController::class)->except('show');
    Route::resource('genres', AdminGenreController::class)->except('show');
    Route::resource('casts', AdminCastController::class)->except('show');

    Route::get('kritiks', [AdminKritikController::class, 'index'])->name('kritiks.index');
    Route::delete('kritiks/{kritik}', [AdminKritikController::class, 'destroy'])->name('kritiks.destroy');

    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');

    Route::get('subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');
});
