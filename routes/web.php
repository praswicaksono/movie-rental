<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Members;
use App\Http\Livewire\Movies;
use App\Http\Livewire\Lending;
use App\Http\Livewire\MovieReturned;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/members', Members::class)
    ->name('members');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/movies', Movies::class)
    ->name('movies');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/movie/lending', Lending::class)
    ->name('lending');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard/movie/return', MovieReturned::class)
    ->name('return');


