<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
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
        // Route::group(['middleware' => 'auth:admin', 'as' => 'admin.'], function () {
        //     #placeholder route
        //     Route::view('/', 'admin.pages.index')->name('index');
        // });
    });
});
