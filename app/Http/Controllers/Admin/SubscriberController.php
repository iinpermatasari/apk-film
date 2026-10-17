<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Daftar pelanggan newsletter.
     */
    public function index()
    {
        $subscribers = Subscriber::latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.subscribers.index', compact('subscribers'));
    }

    /**
     * Hapus pelanggan newsletter.
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()
            ->route('admin.subscribers.index')
            ->with('success', 'Subscriber berhasil dihapus.');
    }
}
