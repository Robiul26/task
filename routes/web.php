<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



Route::get('/', [ImportController::class, 'showForm'])->name('import.form');
Route::post('/import', [ImportController::class, 'importCsv'])->name('customers.import');
Route::resource('/customers', CustomerController::class);


// Route::get('/test-email', function () {
//     try {
//         Mail::to('career@akaarit.com')->send(new \App\Mail\ImportCompletedNotification());
//         return 'Email sent successfully!';
//     } catch (\Exception $e) {
//         return 'Error: ' . $e->getMessage();
//     }
// });

