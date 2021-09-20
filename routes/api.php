<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionsController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\AccountController;
use App\Http\Controllers\Api\Products\CategoryController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Products\ProductMerchantController;
use App\Http\Controllers\Api\Products\VariantController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\Information\NewsController;
use App\Http\Controllers\Api\Service\MethodController;
use App\Http\Controllers\Api\Store\SeatController;
use App\Http\Controllers\Api\Store\StoreController;
use App\Http\Controllers\Api\Voucher\VoucherController;
use App\Http\Controllers\Api\GetIPCityController;
use App\Http\Controllers\Api\Events\EventController;

Route::group(['prefix' => 'v1','namespace' => 'Api', 'as' => 'api.'], function() {
    Route::get('location', [GetIPCityController::class, 'index']);
    Route::get('states', [RegionsController::class, 'provinces'])->name('regions.states');
    Route::get('cities', [RegionsController::class, 'cities'])->name('regions.cities');
    Route::get('city', [RegionsController::class, 'city'])->name('regions.city');
    Route::get('districts', [RegionsController::class, 'districts'])->name('regions.districts');

    Route::post('login/email', [LoginController::class,'mail'])->name('login.mail');
    Route::post('login/phone', [LoginController::class,'phone'])->name('login.phone');
    Route::post('login/otp', [LoginController::class,'otp'])->name('login.otp');
    Route::post('register', [RegisterController::class,'phone'])->name('register');
    Route::post('register/verification', [RegisterController::class,'verification'])->name('register.verification');
    Route::get('slider', [SliderController::class,'index']);
    Route::get('slider/store/{id}', [SliderController::class,'store']);
    Route::get('news', [NewsController::class,'index']);

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('method', [MethodController::class,'index']);
        Route::get('account', [AccountController::class,'index']);
        Route::post('account/change', [AccountController::class,'changeProfile']);
        Route::post('change_password', [AccountController::class,'updatepassword']);

        Route::get('category', [CategoryController::class,'index']);
        Route::get('product/all', [ProductMerchantController::class,'index']);
        Route::get('product/store/{id}', [ProductController::class,'index']);
        Route::get('product/detail/{id}', [ProductController::class,'detail']);

        Route::get('product/popular', [ProductMerchantController::class,'popular']);
        Route::get('product/promo', [ProductController::class,'promo']);
        Route::get('product/variant/{productid}', [VariantController::class,'index']);

        Route::get('voucher', [VoucherController::class,'index']);
        Route::get('stores', [StoreController::class,'index']);
        Route::get('seat/{storeid}', [SeatController::class,'index']);

        Route::get('event', [EventController::class,'index']);

    });
});