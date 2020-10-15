<?php

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

Route::get('/', function () {
    return view('website.home');
});
Route::get('/track', function () {
    return view('website.track');
});

Route::get('/packages', function () {
    return view('admin.packages');
});

Route::get('/settings/general', function () {
    return view('admin.settings.general');
});
Route::get('/settings/businesses', function () {
    return view('admin.settings.businesses');
});
Route::get('/settings/users', function () {
    return view('admin.settings.users');
});
Route::get('/settings/account', function () {
    return view('admin.settings.account');
});
