<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Notifications\NewUserJoined;
use Illuminate\Support\Facades\Notification;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    private function generateUsername(string $email): string
    {
        $base = Str::before($email, '@');
        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $counter;
            $counter++;
        }

        return $username;
    }


    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        $roleUserId = Role::where('name', 'user')->value('id');

        if ($user) {
            // jika user sudah ada
            $user->update([
                'google_id' => $googleUser->getId(),
            ]);
        } else {
            // user baru dari google
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'username' => $this->generateUsername($googleUser->getEmail()),
                'password' => bcrypt(Str::random(16)),
                'role_id' => $roleUserId, // role user
            ]);

            // Kirim notif ke admin
            Notification::route('mail', env('ADMIN_EMAIL'))
                ->notify(new NewUserJoined($user));
        }

        Auth::login($user);

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

                if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if (! $user->profile_completed) {
            return redirect()->route('profile.complete');
        }

        return redirect()->route('dashboard');

    }
}
