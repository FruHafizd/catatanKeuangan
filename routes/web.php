<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/home', Home::class)->middleware(['auth', 'verified'])->name('home');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
