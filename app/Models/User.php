<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'username',
        'role_id',
        'telepon',
        'alamat',
        'avatar',
        'password',
        'profile_completed',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function hasRole(string $role): bool
    {
        return $this->role->name === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role->name, $roles);
    }

    public function dashboardRoute()
    {
        $role = $this->role->name ?? null;

        switch ($role) {
            case 'super_admin':
                return route('super_admin.dashboard');

            case 'admin':
                return route('admin.dashboard');

            case 'editor':
                return route('editor.dashboard');

            case 'author':
                return route('author.dashboard');

            default:
                return route('dashboard');
        }
    }

}
