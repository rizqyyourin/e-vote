<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Voter routes
Route::middleware(['auth', 'voter'])->prefix('voter')->name('voter.')->group(function () {
    Route::get('/dashboard', function () {
        return view('voter.dashboard');
    })->name('dashboard');
    
    // Settings/Profile routes
    Route::get('/settings', function () {
        return view('voter.settings');
    })->name('settings');
    Route::delete('/account', [AuthController::class, 'deleteAccount'])->name('account.delete');
    
    // Voting creation/management routes (voter can create votings)
    Route::get('/voting/create', function () {
        return view('voting.create');
    })->name('voting.create');
    Route::get('/voting/{voting}/edit', function (\App\Models\Voting $voting) {
        // Only user who created this voting can edit it
        if ($voting->admin_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('voting.edit', ['voting' => $voting]);
    })->name('voting.edit');
    Route::delete('/voting/{voting}', function (\App\Models\Voting $voting) {
        // Only user who created this voting can delete it
        if ($voting->admin_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $voting->delete();
        return redirect()->route('voter.dashboard')->with('flash', 'Vote deleted successfully!');
    })->name('voting.delete');
});

// Public voting access (no auth required for viewing, but auth required for voting)
Route::get('/voting/{voting}', function (\App\Models\Voting $voting) {
    return view('voting.show', ['voting' => $voting]);
})->name('voting.show');

// PDF exports
Route::get('/voting/{voting}/pdf', [App\Http\Controllers\VotingPdfController::class, 'exportResultsPublic'])->name('voting.pdf');
