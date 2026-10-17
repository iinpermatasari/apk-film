<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    /**
     * Store a new newsletter subscriber.
     */
    public function store(Request $request)
    {
        // Pakai error bag "subscribe" agar error form footer tidak
        // mengganggu logika modal login (yang memakai bag default).
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:subscribers,email'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'subscribe')
                ->withInput();
        }

        Subscriber::create([
            'email' => $validator->validated()['email'],
        ]);

        return back()->with('subscribe_success', 'Terima kasih! Email kamu sudah terdaftar.');
    }
}
