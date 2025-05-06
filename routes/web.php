<?php

use App\Livewire\Poll\PollMatrix;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web'])->group(function () {
    Route::get('polls/{public_token}', PollMatrix::class)->name('polls');
});
