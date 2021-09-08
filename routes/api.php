<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionsController;
use App\Http\Controllers\Api\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'v1','namespace' => 'Api', 'as' => 'api.'], function() {
    Route::get('states', [RegionsController::class, 'provinces'])->name('regions.states');
    Route::get('cities', [RegionsController::class, 'cities'])->name('regions.cities');
    Route::get('city', [RegionsController::class, 'city'])->name('regions.city');
    Route::get('districts', [RegionsController::class, 'districts'])->name('regions.districts');

    Route::post('login/email', [LoginController::class,'mail'])->name('login.mail');
    Route::post('login/phone', 'Auth\LoginController@phone')->name('login.phone');
    Route::post('login/otp', 'Auth\LoginController@otp')->name('verify_otp');
    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::post('register/otp', 'Auth\RegisterController@otp')->name('register_otp');


    Route::group(['middleware' => 'auth:api'], function(){


    });
});