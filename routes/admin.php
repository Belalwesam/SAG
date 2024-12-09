<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Auth\AuthController;
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
    Route::prefix('admin')->group(function () {
        #auth routes
        Route::view('login', 'admin.auth.login')->name('admin.login_form')->middleware('guest:admin');
        Route::post('login', [AuthController::class, 'login'])->name('admin.login')->middleware('guest:admin');
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');

        #routes that need authetication to interact with
        Route::group(['middleware' => 'auth:admin', 'as' => 'admin.'], function () {
            #placeholder route
            Route::view('/', 'admin.pages.index')->name('index');



            #roles routes (prefix is stand alone because of overlapping)
            Route::prefix('roles')->group(function () {
                Route::group(['as' => 'roles.', 'controller' => RoleController::class, 'middleware' => ['can:see roles']], function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                    Route::patch('/', 'update')->name('update');
                    Route::get('/role-users', 'getRoleUsers')->name('role_users'); // get role users for datatable
                });
            });


            #admins crud routes (prefix is stand alone because of overlapping)
            Route::prefix('admins')->group(function () {
                Route::group(['as' => 'admins.', 'controller' => AdminController::class, 'middleware' => ['can:see admins']], function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                    Route::patch('/', 'update')->name('update');
                    Route::delete('/', 'destroy')->name('delete');
                    Route::get('/admins-list', 'getAdminsList')->name('admins_list'); // get role users for datatable
                });
            });

            #clients crud routes (prefix is stand alone because of overlapping)
            Route::prefix('clients')->group(function () {
                Route::group(['as' => 'clients.', 'controller' => ClientController::class, 'middleware' => ['can:see clients']], function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                    Route::patch('/', 'update')->name('update');
                    Route::delete('/', 'destroy')->name('delete');
                    Route::get('/clients-list', 'getClientsList')->name('clients_list'); // get role users for datatable

                    # client prokects route
                    Route::get('/{id}/projects', 'projects')->name('projects');
                });
            });



            #projects crud routes (prefix is stand alone because of overlapping)
            Route::prefix('projects')->group(function () {
                Route::group(['as' => 'projects.', 'controller' => ProjectController::class, 'middleware' => ['can:see projects']], function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                    Route::patch('/', 'update')->name('update');
                    Route::delete('/', 'destroy')->name('delete');
                    Route::get('/projects-list', 'getProjectsList')->name('projects_list'); // get role users for datatable
                });
            });
        });
    });
});
