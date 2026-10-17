<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kritik;

class KritikController extends Controller
{
    /**
     * Daftar ulasan pengguna untuk moderasi.
     */
    public function index()
    {
        $kritiks = Kritik::with(['user', 'film'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.kritiks.index', compact('kritiks'));
    }

    /**
     * Hapus ulasan pengguna.
     */
    public function destroy(Kritik $kritik)
    {
        $kritik->delete();

        return redirect()
            ->route('admin.kritiks.index')
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}
