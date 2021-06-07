<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Userinformations;

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
Route::get('/user', [Userinformations::class, 'index']);
Route::post('/user/fetch', [Userinformations::class, 'pagination'])->name('user.pagination');
Route::post('/add-user', [Userinformations::class, 'create'])->name('user.create');
Route::get('/user/{id}', [Userinformations::class, 'edit']);
Route::put('/update-user', [Userinformations::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [Userinformations::class, 'delete']);
