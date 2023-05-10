<?php

use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getToken', [SpotifyController::class, 'getToken']) -> name('getToken');
Route::get('/getArtist/{idArtist}', [SpotifyController::class, 'getArtist']) -> name('getArtist');
Route::get('/getTrack/{idTrack}', [SpotifyController::class, 'getTrack']) -> name('getTrack');
Route::get('/getAlbum/{idAlbum}', [SpotifyController::class, 'getAlbum']) -> name('getAlbum');
