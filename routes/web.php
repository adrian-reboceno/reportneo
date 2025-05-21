<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NeoTenantController;
use App\Http\Controllers\NeoApiController; 
use App\Http\Controllers\NeoOrganizationController; 
use App\Http\Controllers\SyncNeoOrganizationController;
use App\Http\Controllers\NeoStatusController;




Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    // otras rutas protegidas...
});

Route::middleware('auth')->group(function () {
    Route::resource('manager/users', UserController::class);
    Route::resource('manager/roles', RoleController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::resource('catalog/status', StatusController::class);
});
Route::middleware('auth')->group(function () {
    Route::resource('cypherlearning/neotenants', NeoTenantController::class);
    Route::resource('cypherlearning/neoapis', NeoApiController::class);
    Route::resource('cypherlearning/neoorganizations', NeoOrganizationController::class);
    Route::resource('cypherlearning/neostatuses', NeoStatusController::class);
});
Route::middleware('auth')->group(function () {
    Route::resource('neosync/syncorganizations', SyncNeoOrganizationController::class);
});
require __DIR__.'/auth.php';

Auth::routes();

/* Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard'); */

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
