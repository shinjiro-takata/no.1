<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

Route::controller(ContactController::class)->group(function () {
    Route::get('/', 'index')->name('contact.index');
    Route::post('/confirm', 'confirm')->name('contact.confirm');
    Route::post('/thanks', 'store')->name('contact.store');
});

Route::middleware('auth')->controller(ContactController::class)->group(function () {
    Route::get('/admin', 'admin')->name('contact.admin');
    Route::get('/search', 'search')->name('contact.search');
    Route::get('/reset', 'reset')->name('contact.reset');
    Route::delete('/delete/{contact}', 'delete')->name('contact.delete');
    Route::get('/export', 'export')->name('contact.export');
});
