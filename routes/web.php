<?php

use App\Http\Livewire\Admin\ManagePackages;
use App\Http\Livewire\Admin\Settings\AccountSettings;
use App\Http\Livewire\Admin\Settings\BusinessSettings;
use App\Http\Livewire\Admin\Settings\GeneralSettings;
use App\Http\Livewire\Admin\Settings\Pricing;
use App\Http\Livewire\Admin\Settings\UserSettings;
use App\Http\Livewire\Website\HomePage;
use App\Http\Livewire\Website\TrackPackage;
use Illuminate\Support\Facades\Route;


Route::get('/', HomePage::class)->name('home');
Route::get('/track', TrackPackage::class)->name('track');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/packages', ManagePackages::class)
        ->name('admin.packages');
    Route::get('/settings/account', AccountSettings::class)
        ->name('admin.settings.account');
});

Route::middleware(['auth', 'superadmin'])->group(function () {

    Route::get('/settings/general', GeneralSettings::class)
        ->name('admin.settings.general');

    Route::get('/settings/businesses', BusinessSettings::class)
        ->name('admin.settings.businesses');

    Route::get('/settings/pricing', Pricing::class)
        ->name('admin.settings.pricing');

    Route::get('/settings/users', UserSettings::class)
        ->name('admin.settings.users');
});
