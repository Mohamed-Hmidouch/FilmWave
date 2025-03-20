<?php

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


Route::get('/home', function () {
    return view('home');
})->name('home');
Route::get('/movies', function () {
    return view('movies');
})->name('movies');

Route::get('/tvshows', function () {
    return view('tvshows');
})->name('tvshows');

Route::get('/new-releases', function () {
    return view('new-releases');
})->name('new-releases');

Route::get('/my-list', function () {
    return view('my-list');
})->name('my-list');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::post('/logout', function () {
    // Logout logic here
    return redirect('/');
})->name('logout');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [App\Http\Controllers\auth\AuthController::class, 'login'])->name('login.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [App\Http\Controllers\auth\AuthController::class, 'register'])->name('register.submit');
