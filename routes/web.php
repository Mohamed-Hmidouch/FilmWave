<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\ActorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\SeriesController;

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



Route::get('/', [HomeController::class, 'welcome']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/movies', [HomeController::class, 'movies'])->name('movies');
Route::get('/tvshows', [HomeController::class, 'tvshows'])->name('tvshows');
Route::get('/new-releases', [HomeController::class, 'newReleases'])->name('new-releases');

Route::get('/login', [App\Http\Controllers\Auth\AuthViewController::class, 'showLogin'])->name('login');
Route::get('/register', [App\Http\Controllers\Auth\AuthViewController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:PremiumUser,FreeUser'])->group(function () {
    Route::get('/my-list', [HomeController::class, 'myList'])->name('my-list');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
});


Route::get('user/homme', [UserController::class, 'index'])->name('user.homme');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Movie management
    
    // Tag management
    Route::resource('tags', TagController::class);
    Route::resource('series', SeriesController::class);
    Route::resource('categories', CategorieController::class);
    
    // Actor management
    // Route::resource('actors', ActorController::class);
    

});


Route::get('subscribe', [App\Http\Controllers\SubscriptionController::class, 'showSubscriptionPage'])->name('subscribe');



Route::get('subscribe/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout');

Route::get('subscribe/checkout/cancel', [App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::get('subscribe/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

Route::post('subscribe/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('subscribe.checkout');


