<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'customer') {
            return redirect()->route('customer.dashboard');
        }
        return redirect()->route('provider.dashboard');
    }

    return redirect()->route('login.show');
});

Route::middleware('guest')->group(function () {

    // Registration
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

});

Route::middleware('auth')->get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('customer')->name('customer.')->middleware(['auth','role:customer'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function() {
        return view('customer.dashboard');
    })->name('dashboard');

    // Jobs
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');       // My Jobs
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');

    // View quotes for a specific job
    Route::get('/jobs/{id}/quotes', [QuoteController::class, 'jobQuotes'])->name('jobs.quotes');

    // Accept a quote
    Route::post('/quotes/{quote}/accept', [QuoteController::class, 'accept'])->name('quotes.accept');

});

Route::prefix('provider')->name('provider.')->middleware(['auth','role:provider'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function() {
        return view('provider.dashboard');
    })->name('dashboard');

    // View Open Jobs
    Route::get('/open-jobs', [JobController::class, 'openJobs'])->name('jobs.open');
    Route::get('/jobs/{id}/apply', [QuoteController::class, 'create'])->name('jobs.apply');
    Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');

    // My quotes
    Route::get('/my-quotes', [QuoteController::class, 'myQuotes'])->name('quotes.my');

});



