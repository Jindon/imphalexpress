<?php

use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\PackagesController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\TrackerController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', HomeController::class)->name('home');
Route::get('/track', TrackerController::class)->name('track');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/packages', PackagesController::class)
        ->name('admin.packages');
});

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/settings/general', GeneralSettingsController::class)
        ->name('admin.settings.general');
    Route::get('/settings/businesses', function () {
        return view('admin.settings.businesses');
    });
    Route::get('/settings/users', function () {
        return view('admin.settings.users');
    });
    Route::get('/settings/account', function () {
        return view('admin.settings.account');
    });
});
