<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\IngredientCategoryController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
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
    if(Auth::check()){
        return redirect()->route('admin');
    }
    else {
        return view('welcome');
    }
});

Route::post('/authentication', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

/* @@ admin controllers @@ */

Route::group(['middleware' => ['admin']], function () {

    Route::group(['prefix' => 'admin'], function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('admin');

        Route::group(['prefix' => 'ingredient'], function () {
            Route::group(['prefix' => 'category'], function () {
                Route::get('/', [IngredientCategoryController::class, 'index'])->name('ingredient_categories');
                Route::get('datatable', [IngredientCategoryController::class, 'datatable']);
                Route::post('getdata', [IngredientCategoryController::class, 'getdata']);
                Route::post('store', [IngredientCategoryController::class, 'store']);
                Route::post('update', [IngredientCategoryController::class, 'update']);
                Route::post('status', [IngredientCategoryController::class, 'status']);
            });
            Route::get('/', [IngredientController::class, 'index'])->name('ingredients');
            Route::get('datatable', [IngredientController::class, 'datatable']);
            Route::post('autocomplete', [IngredientController::class, 'autocomplete']);
            Route::post('getdata', [IngredientController::class, 'getdata']);
            Route::post('store', [IngredientController::class, 'store']);
            Route::post('update', [IngredientController::class, 'update']);
            Route::post('status', [IngredientController::class, 'status']);
        });
    });

});