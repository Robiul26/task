<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



Route::get('/', [ImportController::class, 'showForm'])->name('import.form');
Route::post('/import', [ImportController::class, 'importCsv'])->name('customers.import');

