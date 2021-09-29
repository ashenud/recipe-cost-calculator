<?php

use App\Http\Controllers\Admin\AdminController;
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
    });

});