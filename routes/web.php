<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RumusanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MuzakkiController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\SearchController;

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

                Route::post('users/{status}/aktif/reset/{id}', [UserController::class, 'reset']);
                Route::resource('users/{status}/aktif', UserController::class);
            });
            //end::LevelOne

            Route::resource('dashboard/muzakki', MuzakkiController::class);

            Route::resource('dashboard/mustahik', MustahikController::class);
        });
        //end::LevelTwo

        Route::resource('profile', ProfileController::class);
    });

    Route::get('search/another-user/{id}', [SearchController::class, 'anotherUserId']);
    Route::get('search/another-user', [SearchController::class, 'anotherUser']);
});
