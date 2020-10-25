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
    Route::get('/edit-domain/{id}', [DomainController::class, 'edit'])->name('edit-domain');
    Route::post('/search', [DomainController::class, 'search'])->name('domain-search');
    Route::post('/refresh', [DomainController::class, 'refresh'])->name('refresh-dns');
    Route::post('/domains/getDomains', [DomainController::class, 'getDomains'])->name('domains.getDomains');
    Route::post('/check', [DomainController::class, 'check'])->name('domain-dns-check');

    Route::post('/delete-domain/{id}', [DomainController::class, 'destroy'])->name('delete-domain');

    Route::get('/edit-server/{id}', [ServerController::class, 'edit'])->name('edit-server');
    Route::post('/delete-server/{id}', [ServerController::class, 'destroy'])->name('delete-server');
});
