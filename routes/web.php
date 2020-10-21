<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ServerController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::prefix('servers')->name('server.')->group(function() {
        Route::get('/', [ServerController::class, 'index'])->name('list');
        Route::post('create', [ServerController::class, 'store'])->name('store');
        Route::get('{server}', [ServerController::class, 'edit'])->name('edit');
        Route::put('{id}', [ServerController::class, 'update'])->name('update');
        Route::delete('{server}', [ServerController::class, 'destroy'])->name('delete');
    });

    Route::get('/', [DomainController::class, 'index'])->name('dashboard');
    Route::get('/{name}', [DomainController::class, 'show'])->name('domain-single');
    Route::post('/search', [DomainController::class, 'search'])->name('domain-search');
    Route::post('/add-domain', [DomainController::class, 'store'])->name('add');
    Route::post('/refresh', [DomainController::class, 'refresh'])->name('refresh-dns');
    Route::post('/domains/getDomains/', [DomainController::class, 'getDomains'])->name('domains.getDomains');
    Route::post('/check', [DomainController::class, 'check'])->name('domain-dns-check');
    Route::get('/external', [DomainController::class, 'external'])->name('domain-dns-external');

    Route::get('/edit-domain/{id}', [DomainController::class, 'edit'])->name('edit-domain');
    Route::put('/edit-domain/{id}', [DomainController::class, 'update'])->name('update-domain');
    Route::post('/delete-domain/{id}', [DomainController::class, 'destroy'])->name('delete-domain');
});
