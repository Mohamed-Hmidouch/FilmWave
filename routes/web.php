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
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\VideoPlayerController;

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
    
    // Routes pour le visionnage de vidéos
    Route::get('/watch/series/{seriesId}/{episodeId?}', [VideoPlayerController::class, 'watchEpisode'])->name('watch.episode');
    Route::get('/watch/movie/{movieId}', [VideoPlayerController::class, 'watchMovie'])->name('watch.movie');
    
    // Routes pour le téléchargement de vidéos
    Route::get('/download/series/{seriesId}/{episodeId}', [VideoPlayerController::class, 'downloadEpisode'])->name('download.episode');
    Route::get('/download/movie/{movieId}', [VideoPlayerController::class, 'downloadMovie'])->name('download.movie');
});


Route::get('user/homme', [UserController::class, 'index'])->name('user.homme');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Movie management
    
    // Tag management
    Route::resource('tags', TagController::class);
    Route::post('tags/batch', [TagController::class, 'storeBatch'])->name('tags.batch.store');
    Route::delete('tags/batch', [TagController::class, 'destroyBatch'])->name('tags.batch.destroy');
    Route::post('tags/import', [TagController::class, 'import'])->name('tags.import');
    Route::get('tags/export', [TagController::class, 'export'])->name('tags.export');
    
    Route::resource('series', SeriesController::class);
    Route::resource('categories', CategorieController::class);
    Route::post('categories/batch', [CategorieController::class, 'storeBatch'])->name('categories.batch.store');
    Route::delete('categories/batch', [CategorieController::class, 'destroyBatch'])->name('categories.batch.destroy');
    Route::post('categories/import', [CategorieController::class, 'import'])->name('categories.import');
    Route::get('categories/export', [CategorieController::class, 'export'])->name('categories.export');
    
    // Actor management
    // Route::resource('actors', ActorController::class);
    

});


Route::get('subscribe', [App\Http\Controllers\SubscriptionController::class, 'showSubscriptionPage'])->name('subscribe');



Route::get('subscribe/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout');

Route::get('subscribe/checkout/cancel', [App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::get('subscribe/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

Route::post('subscribe/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('subscribe.checkout');


