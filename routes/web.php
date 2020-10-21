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
    Route::get('/', [DomainController::class, 'index'])->name('dashboard');
    Route::get('/servers', [ServerController::class, 'index'])->name('servers');
    Route::get('/{name}', [DomainController::class, 'show'])->name('domain-single');
    Route::get('/edit-server/{id}', [ServerController::class, 'edit'])->name('edit-server');
    Route::put('/edit-server/{id}', [ServerController::class, 'update'])->name('update-server');
    Route::post('/delete-server/{id}', [ServerController::class, 'destroy'])->name('delete-server');
    Route::post('/search', [DomainController::class, 'search'])->name('domain-search');
    Route::post('/add-domain', [DomainController::class, 'store'])->name('add');
    Route::post('/add-server', [ServerController::class, 'store'])->name('add-server');
    Route::post('/refresh', [DomainController::class, 'refresh'])->name('refresh-dns');

    Route::post('/domains/getDomains/', [DomainController::class, 'getDomains'])->name('domains.getDomains');

    Route::post('/check', [DomainController::class, 'check'])->name('domain-dns-check');
    Route::get('/external', [DomainController::class, 'external'])->name('domain-dns-external');

    Route::get('/edit-domain/{id}', [DomainController::class, 'edit'])->name('edit-domain');
    Route::put('/edit-domain/{id}', [DomainController::class, 'update'])->name('update-domain');
    Route::post('/delete-domain/{id}', [DomainController::class, 'destroy'])->name('delete-domain');
});
