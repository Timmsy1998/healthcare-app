<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Patients;

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/patients', Patients::class)->name('patients');
});