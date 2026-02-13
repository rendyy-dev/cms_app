<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('super_admin.dashboard', [
            'totalUsers' => User::count(),
            'totalRoles' => Role::count(),
            'recentUsers' => User::latest()->take(5)->get(),
        ]);
    }

    public function users()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function roles()
    {
        $roles = Role::all();
        return view('super_admin.roles', compact('roles'));
    }

    public function settings()
    {
        return view('super_admin.settings');
    }

    public function profile()
    {
        return view('super_admin.profile', [
            'user' => auth()->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required'],
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $user->id],
            'username' => ['required','string','max:50','unique:users,username,' . $user->id],
            'telepon' => ['nullable','string','max:20'],
            'alamat' => ['nullable','string','max:255'],
            'avatar' => ['nullable','image','max:2048'],
        ]);

        // ✅ Cek password dulu
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password tidak sesuai.'
            ])->withInput();
        }

        if ($request->hasFile('avatar')) {

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

        return back()->with('success','Profile berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        // cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

}
