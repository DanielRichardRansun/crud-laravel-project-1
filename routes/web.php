<?php

use App\Http\Controllers\mahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//direct ke web dari file app/http/mahasiswaController
Route::resource('mahasiswa', mahasiswaController::class);
