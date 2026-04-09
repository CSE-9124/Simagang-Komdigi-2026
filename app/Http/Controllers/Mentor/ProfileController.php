<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        if (!$mentor) {
            return redirect()->route('mentor.dashboard')->withErrors(['error' => 'Data profil tidak ditemukan.']);
        }

        return view('mentor.profile.show', compact('mentor', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        if (!$mentor) {
            return redirect()->route('mentor.dashboard')->withErrors(['error' => 'Data profil tidak ditemukan.']);
        }

        return view('mentor.profile.edit', compact('mentor', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $mentor = $user->mentor;

        if (!$mentor) {
            return redirect()->route('mentor.dashboard')->withErrors(['error' => 'Data profil tidak ditemukan.']);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ];

        // Only require password fields if password is being changed
        if ($request->filled('password')) {
            $rules['current_password'] = ['required', 'string'];
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        $validated = $request->validate($rules);

        // Update user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // Update mentor data
        $mentor->name = $validated['name'];
        $mentor->phone = $validated['phone'];
        $mentor->save();

        // Update password if provided
        if ($request->filled('password')) {
            // Verify current password
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withInput();
            }

            $user->password = Hash::make($validated['password']);
            $user->save();
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($mentor->photo_path && file_exists(storage_path('app/public/' . $mentor->photo_path))) {
                unlink(storage_path('app/public/' . $mentor->photo_path));
            }

            $photoPath = $request->file('photo')->store('photos', 'public');
            $mentor->photo_path = $photoPath;
        }

        $mentor->save();

        return redirect()->route('mentor.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}