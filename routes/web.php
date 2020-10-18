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



Route::middleware(['auth:sanctum', 'verified'])->get('/test', [DomainController::class, 'test'])->name('test');
Route::middleware(['auth:sanctum', 'verified'])->get('/', [DomainController::class, 'index'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/servers', [ServerController::class, 'index'])->name('servers');
Route::middleware(['auth:sanctum', 'verified'])->get('/{name}', [DomainController::class, 'show'])->name('domain-single');
Route::middleware(['auth:sanctum', 'verified'])->get('/edit-server/{id}', [ServerController::class, 'edit'])->name('edit-server');
Route::middleware(['auth:sanctum', 'verified'])->put('/edit-server/{id}', [ServerController::class, 'update'])->name('update-server');
Route::middleware(['auth:sanctum', 'verified'])->post('/delete-server/{id}', [ServerController::class, 'destroy'])->name('delete-server');
Route::middleware(['auth:sanctum', 'verified'])->post('/search', [DomainController::class, 'search'])->name('domain-search');
Route::middleware(['auth:sanctum', 'verified'])->post('/add-domain', [DomainController::class, 'store'])->name('add');
Route::middleware(['auth:sanctum', 'verified'])->post('/add-server', [ServerController::class, 'store'])->name('add-server');
Route::middleware(['auth:sanctum', 'verified'])->post('/refresh', [DomainController::class, 'refresh'])->name('refresh-dns');

Route::middleware(['auth:sanctum', 'verified'])->post('/domains/getDomains/', [DomainController::class, 'getDomains'])->name('domains.getDomains');

Route::middleware(['auth:sanctum', 'verified'])->post('/check', [DomainController::class, 'check'])->name('domain-dns-check');
Route::middleware(['auth:sanctum', 'verified'])->get('/external', [DomainController::class, 'external'])->name('domain-dns-external');


Route::middleware(['auth:sanctum', 'verified'])->get('/edit-domain/{id}', [DomainController::class, 'edit'])->name('edit-domain');
Route::middleware(['auth:sanctum', 'verified'])->put('/edit-domain/{id}', [DomainController::class, 'update'])->name('update-domain');
Route::middleware(['auth:sanctum', 'verified'])->post('/delete-domain/{id}', [DomainController::class, 'destroy'])->name('delete-domain');
