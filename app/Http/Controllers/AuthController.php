<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Fallback page for guests redirected by the "auth" middleware.
     * Auth is delivered through a modal, so we simply send users home.
     */
    public function showLogin(): RedirectResponse
    {
        return redirect()->route('home');
    }

    /**
     * Handle a registration (Sign Up) request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            // Tabel users memiliki foreign key NOT NULL: profile_id & role_id.
            // Jadi profil dan role harus dibuat lebih dulu.
            $profile = Profile::create([
                'umur' => 0,
                'bio' => '',
                'alamat' => '',
                'phone' => $validated['phone'],
            ]);

            $role = Role::firstOrCreate(['name' => 'user']);

            return User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $role->id,
                'profile_id' => $profile->id,
            ]);
        });

        Auth::login($user);

        // Cegah session fixation setelah perubahan status autentikasi.
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('status', 'Registrasi berhasil. Selamat datang, '.$user->name.'!');
    }

    /**
     * Handle an authentication (Sign In) request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // attempt() otomatis mencocokkan password plaintext dengan hash di database.
        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        // Regenerate session untuk mencegah session fixation.
        $request->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('status', 'Berhasil login.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Anda telah logout.');
    }
}
