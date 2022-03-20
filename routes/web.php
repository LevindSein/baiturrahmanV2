<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RumusanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MuzakkiController;

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
        //begin::LevelTwo
        Route::middleware('leveltwo')->group(function(){
            //begin::LevelOne
            Route::middleware('levelone')->group(function(){
                Route::resource('dashboard/rumusan', RumusanController::class);

                Route::post('users/{status}/aktif/change/{id}', [UserController::class, 'change']);
                Route::post('users/{status}/aktif/reset/{id}', [UserController::class, 'reset']);
                Route::resource('users/{status}/aktif', UserController::class);
            });
            //end::LevelOne

            Route::resource('dashboard/muzakki', MuzakkiController::class);
        });
        //end::LevelTwo

        Route::resource('profile', ProfileController::class);
    });
});
