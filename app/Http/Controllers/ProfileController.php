<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Form edit profile
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profile utama
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9._]+$/',
                'unique:users,username,' . $user->id,
            ],
            'telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        // Reset verifikasi kalau email berubah
        if ($user->email !== $request->email) {
            $user->email_verified_at = null;
        }

        // Upload avatar baru
        if ($request->hasFile('avatar')) {

            // Hapus avatar lama kalau ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => strtolower($request->username),
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Profile berhasil diperbarui.');
    }

    /**
     * Complete profile (Google user)
     */
    public function complete(): View|RedirectResponse
    {
        if (auth()->user()->profile_completed) {
            return redirect()->route('dashboard');
        }

        return view('profile.complete');
    }

    /**
     * Simpan data complete profile
     */
    public function storeComplete(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
                'regex:/^[a-z0-9._]+$/'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $user->update([
            'username' => strtolower($request->username),
            'password' => Hash::make($request->password),
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'profile_completed' => true,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Profil berhasil dilengkapi 🎉');
    }

    /**
     * Hapus akun
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Hapus avatar kalau ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
