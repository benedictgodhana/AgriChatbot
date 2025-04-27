<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserController;
use App\Models\Setting;
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

// Group routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Chatbot dashboard route (only accessible to authenticated users)
    Route::get('/chats', [ChatbotController::class, 'index'])->name('chats');
    Route::get('/chatbot-dashboard', [ChatbotController::class, 'show'])->name('chatbot-dashboard');
    // Route to handle chatbot interactions
    // In routes/web.php


    //user route



    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::post('/users/{user}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');


    Route::get('/chatbot-dashboard', [ChatbotController::class, 'index'])->name('chats'); // <-- no token
    Route::get('/chat/{token}', [ChatbotController::class, 'show'])->name('chat.show'); // <-- needs token
     Route::post('/chatbot', [ChatbotController::class, 'store'])->name('chatbot.store');
     Route::get('/chat/{chatId}', [ChatbotController::class, 'showInteraction'])->name('chatbot.showInteraction');
     Route::get('/chats/create', [ChatbotController::class, 'create'])->name('chats.create');
     Route::post('/chat/create', [ChatbotController::class, 'createNewChat'])->name('chat.create.new');

    Route::delete('/chatbot/{id}', [ChatbotController::class, 'destroyInteraction'])->name('chatbot.destroy');
    Route::get('/chatbot/{id}/edit', [ChatbotController::class, 'editInteraction'])->name('chatbot.edit');
    Route::patch('/chatbot/{id}', [ChatbotController::class, 'updateInteraction'])->name('chatbot.update');
    Route::get('/chatbot/{id}/export', [ChatbotController::class, 'exportInteraction'])->name('chatbot.export');
    Route::get('/chatbot/{id}/delete', [ChatbotController::class, 'deleteInteraction'])->name('chatbot.delete');
    Route::get('/chatbot/{id}/download', [ChatbotController::class, 'downloadInteraction'])->name('chatbot.download');
    Route::get('/chatbot/{id}/share', [ChatbotController::class, 'shareInteraction'])->name('chatbot.share');
    Route::get('/chatbot/{id}/share-link', [ChatbotController::class, 'generateShareLink'])->name('chatbot.share-link');
    Route::get('/chatbot/{id}/share-link/{token}', [ChatbotController::class, 'viewSharedInteraction'])->name('chatbot.view-shared');
    Route::get('/chatbot/{id}/share-link/{token}/download', [ChatbotController::class, 'downloadSharedInteraction'])->name('chatbot.download-shared');
    Route::get('/chatbot/{id}/share-link/{token}/delete', [ChatbotController::class, 'deleteSharedInteraction'])->name('chatbot.delete-shared');
    Route::get('/chatbot/{id}/share-link/{token}/edit', [ChatbotController::class, 'editSharedInteraction'])->name('chatbot.edit-shared');
    Route::patch('/chatbot/{id}/share-link/{token}', [ChatbotController::class, 'updateSharedInteraction'])->name('chatbot.update-shared');


    //products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // Route to handle chatbot interactions


    //Settings route

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/{id}', [SettingsController::class, 'show'])->name('settings.show');
    Route::get('/settings/{id}/edit', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{id}', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/{id}/delete', [SettingsController::class, 'destroy'])->name('settings.destroy');
    Route::get('/settings/{id}/restore', [SettingsController::class, 'restore'])->name('settings.restore');
    Route::get('/settings/{id}/force-delete', [SettingsController::class, 'forceDelete'])->name('settings.force-delete');
    Route::get('/settings/{id}/create', [SettingsController::class, 'create'])->name('settings.create');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
    Route::get('/settings/{id}/export', [SettingsController::class, 'export'])->name('settings.export');
    Route::get('/settings/{id}/download', [SettingsController::class, 'download'])->name('settings.download');
    Route::post('/theme/update', [SettingsController::class, 'update'])->name('theme.update');


    //message route
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

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


