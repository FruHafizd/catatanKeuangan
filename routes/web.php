<?php

use App\Livewire\Home;
use App\Livewire\TransactionHistory;
use \App\Livewire\GoalFinancial;
use App\Livewire\Transactions\History\Index;
use App\Livewire\Transactions\Recurring\Index as RecurringIndex;
Use App\Livewire\DebtPlans\Index as DebtPlanIndex;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', Home::class)->name('home');
    Route::get('/history', Index::class)->name('history');
    Route::get('/recurring-transactions', RecurringIndex::class)->name('recurring-transactions');
    Route::get('/debt-plans', DebtPlanIndex::class)->name('debt-plans');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
