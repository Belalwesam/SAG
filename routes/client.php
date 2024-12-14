<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\TicketController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/

#localization middlewares and prefixing
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect']], function () {
    #add localized routes here and the prexfix them with admin keyword
    Route::prefix('client')->group(function () {
        #auth routes
        Route::view('login', 'client.auth.login')->name('client.login_form')->middleware('guest');
        Route::post('login', [AuthController::class, 'login'])->name('client.login')->middleware('guest');
        Route::get('/logout', [AuthController::class, 'logout'])->name('client.logout')->middleware('auth');

        #routes that need authetication to interact with
        Route::group(['middleware' => 'auth', 'as' => 'client.'], function () {
            #placeholder route
            Route::get('/', HomeController::class)->name('index');


            # tickets routes
            Route::group(["prefix" => "tickets", "controller" => TicketController::class, "as" => "tickets."], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/tickets-list', 'getTicketsList')->name('tickets_list');

                # view the ticket
                Route::get('/{ticket_id}/show', 'show')->name('show');
            });
        });
    });
});
