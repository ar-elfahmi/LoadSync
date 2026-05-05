<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/machines', function () {
    return view('machine_management');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/energy_simulation', function () {
    return view('energy_simulation');
});
