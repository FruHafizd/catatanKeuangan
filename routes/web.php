<?php

use App\Livewire\Home;
use App\Livewire\TransactionHistory;
use \App\Livewire\GoalFinancial;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', Home::class)->name('home');
    Route::get('/history', TransactionHistory::class)->name('history');
    Route::get('/goal-financial', GoalFinancial::class)->name('goal-financial');
});


Route::get('/home', Home::class)->middleware(['auth', 'verified'])->name('home');
Route::get('/history', TransactionHistory::class)->middleware(['auth', 'verified'])->name('history');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
