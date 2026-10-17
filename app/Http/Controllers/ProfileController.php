<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function show()
    {
        $profile = auth()->user()->profile;

        return view('components.profile', compact('profile'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(UpdateProfileRequest $request)
    {
        $profile = auth()->user()->profile;

        $profile->update($request->validated());

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
