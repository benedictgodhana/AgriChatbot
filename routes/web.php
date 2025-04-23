<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root URL to the login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Socialite Google login routes
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

Route::get('/dashboard', function () {
    // Check if the user has the 'view dashboard' permission
    if (Auth::user()->can('view dashboard')) {
        return view('dashboard'); // Allow access to dashboard
    }

    // Redirect to chatbot if user does not have the permission
    return redirect()->route('chatbot-dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Group routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/chatbot-dashboard', [ChatbotController::class, 'show'])->name('chatbot-dashboard');

    // Chatbot route (only accessible to authenticated users)
    Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot');

    // User Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout route (POST method to logout a user)
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
         ->name('logout');
});

// Include the default authentication routes (login, registration, etc.)
require __DIR__.'/auth.php';
