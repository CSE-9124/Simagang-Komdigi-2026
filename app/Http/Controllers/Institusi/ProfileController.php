<?php

namespace App\Http\Controllers\Institusi;

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
        $institusi = $user->institusi;

        if (! $institusi) {
            return redirect()->route('institusi.dashboard')->withErrors(['error' => 'Data profil tidak ditemukan.']);
        }

        return view('institusi.profile.show', compact('institusi', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $institusi = $user->institusi;

        if (! $institusi) {
            return redirect()->route('institusi.dashboard')->withErrors(['error' => 'Data profil tidak ditemukan.']);
        }

        return view('institusi.profile.edit', compact('institusi', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $institusi = $user->institusi;

        if (! $institusi) {
            return redirect()->route('institusi.dashboard')->withErrors(['error' => 'Data profil tidak ditemukan.']);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'nama_institusi' => ['required', 'string', 'max:255'],
            'jenis_institusi' => ['nullable', 'string', 'max:255'],
            'nomor_identitas' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'fakultas' => ['nullable', 'string', 'max:255'],
            'departemen' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ];

        if ($request->filled('password')) {
            $rules['current_password'] = ['required', 'string'];
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        $validated = $request->validate($rules);

        // update user
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // update institusi
        $institusi->nama_institusi = $validated['nama_institusi'];
        $institusi->jenis_institusi = $validated['jenis_institusi'] ?? null;
        $institusi->nomor_identitas = $validated['nomor_identitas'] ?? null;
        $institusi->no_hp = $validated['no_hp'] ?? null;
        $institusi->fakultas = $validated['fakultas'] ?? null;
        $institusi->departemen = $validated['departemen'] ?? null;
        $institusi->save();

        // update password
        if ($request->filled('password')) {
            if (! Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withInput();
            }

            $user->password = Hash::make($validated['password']);
            $user->save();
        }

        return redirect()->route('institusi.profile.show')->with('success', 'Profil institusi berhasil diperbarui.');
    }
}
