<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'g-recaptcha-response' => ['required'],
            ],
            [
                'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA terlebih dahulu.',
            ]
        );

        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (! $response->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal.',
            ]);
        }

        $login = $request->login;

        // Tentukan apakah email atau username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        // Optional: normalize username (jaga-jaga)
        if ($fieldType === 'username') {
            $login = strtolower($login);
        }

        if (! Auth::attempt([
            $fieldType => $login,
            'password' => $request->password,
        ], $request->boolean('remember'))) {

            throw ValidationException::withMessages([
                'login' => 'Username / Email atau password salah.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan role (INI SUDAH BAGUS)
        return match ($user->role->name) {
            'super_admin' => redirect()->route('super_admin.dashboard'),
            'admin'       => redirect()->route('admin.dashboard'),
            'editor'      => redirect()->route('editor.dashboard'),
            'author'      => redirect()->route('author.dashboard'),
            default       => redirect()->route('dashboard'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
