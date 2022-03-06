<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

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
    return redirect('/login');
});

Route::get('logout', [AuthController::class, 'logout']);
Route::resource('login', AuthController::class);


//Login Authenticated
Route::middleware('checkauth')->group(function(){
    Route::prefix('production')->group(function(){
        Route::resource('dashboard', DashboardController::class);

        Route::resource('profile', ProfileController::class);
    });
});
