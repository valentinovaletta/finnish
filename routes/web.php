<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewWord;
use App\Http\Controllers\NewEnFi;

use App\Http\Controllers\Test;

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

Route::get('/test',  [Test::class, 'index']);

Route::get('/newword',  [NewWord::class, 'index']);
Route::get('/newenfi',  [NewEnFi::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});
