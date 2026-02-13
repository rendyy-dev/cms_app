<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RoleController;


Route::get('/', function () {
    return view('welcome');
});

// Dashboard umum untuk semua user terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'profile.completed'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Super Admin panel
Route::prefix('super-admin')
    ->name('super_admin.')
    ->middleware(['auth','role:super_admin'])
    ->group(function () {

        Route::get('/', [SuperAdminController::class,'index'])->name('dashboard');
        Route::get('/users', [SuperAdminController::class,'users'])->name('users');
        Route::get('/settings', [SuperAdminController::class,'settings'])->name('settings');

        // Profile khusus super admin
        Route::get('/profile', [SuperAdminController::class, 'profile'])
            ->name('profile');

        Route::patch('/profile', [SuperAdminController::class, 'updateProfile'])
            ->name('profile.update');

        Route::patch('/profile/password', 
            [SuperAdminController::class, 'updatePassword']
        )->name('password.update');

        Route::resource('roles', RoleController::class);
});

// Manajemen User (Super Admin + Admin)
Route::middleware(['auth','role:super_admin,admin'])
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class);
    });

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
    ->name('auth.google');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::middleware(['auth'])
    ->get('/complete-profile', [ProfileController::class, 'complete'])
    ->name('profile.complete');

Route::middleware(['auth'])
    ->post('/complete-profile', [ProfileController::class, 'storeComplete'])
    ->name('profile.complete.store');

Route::middleware(['auth'])->group(function () {

    Route::resource('articles', ArticleController::class);

    Route::post('articles/{article}/submit', [ArticleController::class, 'submit'])
        ->name('articles.submit');

    Route::post('articles/{article}/publish', [ArticleController::class, 'publish'])
        ->name('articles.publish');

    Route::post('articles/{article}/approve', [ArticleController::class, 'approve'])
        ->name('articles.approve');

    Route::post('articles/{article}/reject', [ArticleController::class, 'reject'])
        ->name('articles.reject');

});

require __DIR__.'/auth.php';
