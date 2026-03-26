<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GtkContractController;
use App\Http\Controllers\GtkController;
use App\Http\Controllers\GtkStudyController;
use App\Http\Controllers\Ref\InstansiController;
use App\Http\Controllers\Ref\TugasTambahanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WizardController;
use App\Imports\OldAppImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::middleware(['auth'])->group(function () {
    Route::get('/', DashboardController::class)->name('/');

    Route::get('/wizard', [WizardController::class, 'index'])->name('wizard');
    Route::post('/wizard', [WizardController::class, 'store'])->name('wizard.store');

    Route::resource('gtk', GtkController::class);
    // Route::patch('gtk/{gtk}/generate-credentials', [GtkController::class, 'generateCredentials'])->name('gtk.generate-credentials');
    Route::apiResource('gtk.studies', GtkStudyController::class);
    Route::patch('gtk/{gtk}/studies/{study}/activate', [GtkStudyController::class, 'activate'])->name('gtk.studies.activate');
    Route::apiResource('gtk.contracts', GtkContractController::class);
    Route::patch('gtk/{gtk}/contracts/{contract}/activate', [GtkContractController::class, 'activate'])->name('gtk.contracts.activate');

    Route::name('ref.')->group(function () {
        Route::apiResource('instansi', InstansiController::class);
        Route::apiResource('tugas_tambahan', TugasTambahanController::class);
    });

    Route::apiResource('users', UserController::class);
    Route::patch('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    Route::apiResource('contracts', ContractController::class);
    Route::get('contracts/{contract}/generate', [ContractController::class, 'generate'])->name('contracts.generate');
    Route::post('contracts/generate-batch', [ContractController::class, 'generateBatch'])->name('contracts.generate-batch');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('login/google', [LoginController::class, 'redirectToProvider'])->name('login.google');
    Route::get('login/google/callback', [LoginController::class, 'handleProviderCallback'])->name('login.google.callback');
});

Route::get('test', function () {
    Excel::import(new OldAppImport(), storage_path('QOMARUL.xlsx'));
});
