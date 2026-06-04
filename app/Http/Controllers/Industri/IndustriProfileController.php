<?php

namespace App\Http\Controllers\Industri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industri;
use Illuminate\Support\Facades\Storage;

class IndustriProfileController extends Controller
{
    /**
     * Halaman create + edit profile industri
     */
    public function create()
    {
        $industri = auth()->user()->industri;

        $fields = [
            'nama_industri',
            'bidang_industri',
            'logo_industri',
            'deskripsi_industri',
            'alamat_industri',
            'kota_kabupaten',
            'email_industri',
            'nomor_telepon_industri',
            'nib',
            'jenis_lembaga',
        ];

        $filledFields = 0;

        if ($industri) {
            foreach ($fields as $field) {
                if (!empty($industri->$field)) {
                    $filledFields++;
                }
            }
        }

        $totalFields = count($fields);

        $progress = $totalFields > 0
            ? round(($filledFields / $totalFields) * 100)
            : 0;

        return view('industri.profile.create', compact(
            'industri',
            'progress'
        ));
    }

    /**
     * Simpan / update profile industri
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $industri = $user->industri;

        $validated = $request->validate([
            'nama_industri' => [
                'required',
                'string',
                'max:255'
            ],

            'jenis_lembaga' => [
                'nullable',
                'string',
                'max:255'
            ],

            'bidang_industri' => [
                'required',
                'string',
                'max:255'
            ],

            'logo_industri' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'deskripsi_industri' => [
                'nullable',
                'string'
            ],

            'alamat_industri' => [
                'nullable',
                'string'
            ],

            'kota_kabupaten' => [
                'nullable',
                'string',
                'max:255'
            ],

            'email_industri' => [
                'required',
                'email',
                'max:255'
            ],

            'nomor_telepon_industri' => [
                'required',
                'string',
                'max:20'
            ],

            'nib' => [
                'nullable',
                'string',
                'max:255'
            ],
        ]);

        /**
         * Upload logo
         */
        if ($request->hasFile('logo_industri')) {

            $file = $request->file('logo_industri');

            // Hapus logo lama
            if ($industri && $industri->logo_industri) {
                Storage::disk('public')->delete($industri->logo_industri);
            }

            $validated['logo_industri'] = $file->store(
                'logos-industri',
                'public'
            );
        }

        /**
         * Create atau update profile
         */
        Industri::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'nama_industri' => $validated['nama_industri'],
                'jenis_lembaga' => $validated['jenis_lembaga'] ?? null,
                'bidang_industri' => $validated['bidang_industri'],
                'logo_industri' => $validated['logo_industri']
                    ?? ($industri->logo_industri ?? null),

                'deskripsi_industri' => $validated['deskripsi_industri'] ?? null,

                'alamat_industri' => $validated['alamat_industri'] ?? null,

                'kota_kabupaten' => $validated['kota_kabupaten'] ?? null,

                'email_industri' => $validated['email_industri'],

                'nomor_telepon_industri' => $validated['nomor_telepon_industri'],

                'nib' => $validated['nib'] ?? null,

                // default status
                'status' => $industri->status ?? 'pending',
            ]
        );

        return redirect()
            ->route('industri.dashboard')
            ->with(
                'success',
                $industri
                    ? 'Profil industri berhasil diperbarui.'
                    : 'Profil industri berhasil dibuat.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tidak dipakai karena create + edit jadi satu halaman
     */
    public function edit(string $id)
    {
        return redirect()->route('industri.profile.create');
    }

    /**
     * Tidak dipakai
     */
    public function update(Request $request, string $id)
    {
        return $this->store($request);
    }

    /**
     * Hapus profile industri
     */
    public function destroy(string $id)
    {
        $industri = Industri::findOrFail($id);

        // Hapus logo
        if ($industri->logo_industri) {
            Storage::disk('public')->delete($industri->logo_industri);
        }

        $industri->delete();

        return redirect()
            ->back()
            ->with('success', 'Profil industri berhasil dihapus.');
    }
}