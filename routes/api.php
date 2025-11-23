<?php

use App\Http\Controllers\Api\V1\AgencyController;
use App\Http\Controllers\Api\V1\VendorController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('api.v1.')
    ->middleware('throttle:120,1')
    ->group(function (): void {
        Route::get('agencies', [AgencyController::class, 'index'])->name('agencies.index');
        Route::get('agencies/{agency:slug}', [AgencyController::class, 'show'])->name('agencies.show');

        Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
        Route::get('vendors/{vendor:slug}', [VendorController::class, 'show'])->name('vendors.show');
    });
