<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Sistem\UserController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\Products\CategoryController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Info\SliderController;
use App\Http\Controllers\Info\NewsController;
use App\Http\Controllers\Products\ProductSpecialController;
use App\Http\Controllers\Products\ProductMasterController;
use App\Http\Controllers\Products\ProductPromoController;
use App\Http\Controllers\Products\ProductPairingController;
use App\Http\Controllers\Products\ProductBundleController;
use App\Http\Controllers\Shopp\VoucherController;
use App\Http\Controllers\Sistem\SeatController;
use App\Http\Controllers\Sistem\TaxController;
use App\Http\Controllers\Sistem\ProfileController;
use App\Http\Controllers\Sistem\PaymentMethodController;
use App\Http\Controllers\Sistem\CourierController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Sistem\WorkTimeController;
use App\Http\Controllers\PaymentController;

Route::get('/firebase',[HomeController::class, 'firebasetest']);

Route::get('unauthorised',[LoginController::class,'unauthorised'])->name('unauthorised');
Route::get('/forgot', [ForgotPasswordController::class, 'index'])->name('forgot');
Route::post('/forgot/check', [ForgotPasswordController::class, 'check'])->name('forgot.check');

Route::post('payments/notification', [PaymentController::class,'notification']);
Route::get('payments/completed', [PaymentController::class,'completed']);
Route::get('payments/failed', [PaymentController::class,'failed']);
Route::get('payments/unfinish', [PaymentController::class,'unfinish']);

Auth::routes();   
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfileController::class, 'index'])->name('myprofile');
Route::get('/profile/change', [ProfileController::class, 'change'])->name('profile.change');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/resetpassword', [ProfileController::class, 'resetpassword'])->name('profile.password.reset');
Route::post('/profile/password/update', [ProfileController::class, 'updatepassword'])->name('profile.password.update');

Route::get('/users', [UserController::class, 'index'])->name('user');
Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
Route::get('/users/{id}/edit', [userController::class, 'edit'])->name('user.edit');
Route::post('/users/{id}/update', [userController::class, 'update'])->name('user.update');

Route::get('/order/process', [OrderController::class, 'index'])->name('order');
Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
Route::post('/order/update', [OrderController::class, 'update'])->name('order.update');
Route::get('/order/detail/{id}', [OrderController::class, 'detail'])->name('order.detail');


Route::get('/member', [MemberController::class, 'index'])->name('member');

Route::get('/event/list', [EventController::class, 'index'])->name('event.list');
Route::get('/event/running', [EventController::class, 'running'])->name('event.running');
Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
Route::get('/event/{id}/delete', [EventController::class, 'delete']);
Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
Route::post('/event/{id}/update', [EventController::class, 'update'])->name('event.update');

Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news/news', [NewsController::class, 'store'])->name('news.store');
Route::post('/news/upload', [NewsController::class, 'upload'])->name('news.upload');
Route::get('/news/{id}/delete', [NewsController::class, 'delete']);
Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
Route::post('/news/{id}/update', [NewsController::class, 'update'])->name('news.update');

Route::get('/slider', [SliderController::class, 'index'])->name('slider');
Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
Route::post('/slider/slider', [SliderController::class, 'store'])->name('slider.store');
Route::post('/slider/upload', [SliderController::class, 'upload'])->name('slider.upload');
Route::get('/slider/{id}/delete', [SliderController::class, 'delete']);
Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
Route::post('/slider/{id}/update', [SliderController::class, 'update'])->name('slider.update');

Route::get('/stores', [StoresController::class, 'index'])->name('stores');
Route::get('/stores/create', [StoresController::class, 'create'])->name('stores.create');
Route::post('/stores/stores', [StoresController::class, 'store'])->name('stores.store');
Route::get('/stores/{id}/edit', [StoresController::class, 'edit'])->name('stores.edit');
Route::post('/stores/{id}/update', [StoresController::class, 'update'])->name('stores.update');

Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/stores', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{id}/delete', [CategoryController::class, 'delete'])->name('category.delete');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');

Route::get('/products', [ProductMasterController::class, 'index'])->name('products');
Route::get('/products/create', [ProductMasterController::class, 'create'])->name('products.create');
Route::get('/products/{id}/edit', [ProductMasterController::class, 'edit'])->name('products.edit');
Route::get('/products/{id}/delete', [ProductMasterController::class, 'delete'])->name('products.delete');
Route::post('/products/stores', [ProductMasterController::class, 'store'])->name('products.store');
Route::get('/products/{id}/detail', [ProductMasterController::class, 'detail'])->name('products.detail');
Route::get('/products/{id}/review', [ProductMasterController::class, 'review'])->name('products.review');

Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product/stores', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/{id}/review', [ProductController::class, 'review'])->name('product.review');
Route::get('/product/{id}/detail', [ProductController::class, 'detail'])->name('product.detail');
Route::post('/product/{id}/submit', [ProductController::class, 'submit'])->name('product.submit');
Route::post('/product/upload', [ProductController::class, 'upload'])->name('product.upload');
Route::get('/product/{id}/delete', [ProductController::class, 'delete']);
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');

Route::get('/special', [ProductSpecialController::class, 'index'])->name('product.special');
Route::get('/special/create', [ProductSpecialController::class, 'create'])->name('product.special.create');
Route::post('/special/store', [ProductSpecialController::class, 'store'])->name('product.special.store');
Route::get('/special/{id}/delete', [ProductSpecialController::class, 'delete']);
Route::get('/special/{id}/edit', [ProductSpecialController::class, 'edit'])->name('special.edit');
Route::post('/special/{id}/update', [ProductSpecialController::class, 'update'])->name('special.update');

Route::get('/pairing', [ProductPairingController::class, 'index'])->name('pairing');
Route::get('/pairing/create', [ProductPairingController::class, 'create'])->name('pairing.create');
Route::post('/pairing/store', [ProductPairingController::class, 'store'])->name('pairing.store');
Route::get('/pairing/{id}/delete', [ProductPairingController::class, 'delete']);
Route::get('/pairing/{id}/edit', [ProductPairingController::class, 'edit'])->name('pairing.edit');
Route::post('/pairing/{id}/update', [ProductPairingController::class, 'update'])->name('pairing.update');

Route::get('/bundle', [ProductBundleController::class, 'index'])->name('product.bundle');
Route::get('/bundle/create', [ProductBundleController::class, 'create'])->name('product.bundle.create');
Route::post('/bundle/store', [ProductBundleController::class, 'store'])->name('product.bundle.store');
Route::get('/bundle/{id}/delete', [ProductBundleController::class, 'delete']);
Route::get('/bundle/{id}/edit', [ProductBundleController::class, 'edit'])->name('bundle.edit');
Route::post('/bundle/{id}/update', [ProductBundleController::class, 'update'])->name('bundle.update');
Route::get('/bundle/{id}/generate', [ProductBundleController::class, 'generate'])->name('bundle.generate');

Route::get('/promo', [ProductPromoController::class, 'index'])->name('product.promo');
Route::get('/promo/create', [ProductPromoController::class, 'create'])->name('product.promo.create');
Route::post('/promo/store', [ProductPromoController::class, 'store'])->name('product.promo.store');
Route::get('/promo/{id}/delete', [ProductPromoController::class, 'delete']);
Route::get('/promo/{id}/edit', [ProductPromoController::class, 'edit'])->name('promo.edit');
Route::post('/promo/{id}/update', [ProductPromoController::class, 'update'])->name('promo.update');

Route::post('/product/variant/{id}', [ProductController::class, 'variant'])->name('product.variant');
Route::post('/product/images/{id}', [ProductController::class, 'images'])->name('product.images');

Route::get('/voucher', [VoucherController::class, 'index'])->name('voucher');
Route::get('/voucher/create', [VoucherController::class, 'create'])->name('voucher.create');
Route::post('/voucher/store', [VoucherController::class, 'store'])->name('voucher.store');
Route::get('/voucher/{id}/delete', [VoucherController::class, 'delete']);
Route::get('/voucher/{id}/edit', [VoucherController::class, 'edit'])->name('voucher.edit');
Route::post('/voucher/{id}/update', [VoucherController::class, 'update'])->name('voucher.update');

Route::get('/seat', [SeatController::class, 'index'])->name('seat');
Route::get('/seat/create', [SeatController::class, 'create'])->name('seat.create');
Route::post('/seat/store', [SeatController::class, 'store'])->name('seat.store');
Route::get('/seat/{id}/delete', [SeatController::class, 'delete']);
Route::get('/seat/{id}/edit', [SeatController::class, 'edit'])->name('seat.edit');
Route::post('/seat/{id}/update', [SeatController::class, 'update'])->name('seat.update');

Route::get('/tax', [TaxController::class, 'index'])->name('tax');
Route::post('/tax/store', [TaxController::class, 'store'])->name('tax.store');

Route::get('/paymentmethod', [PaymentMethodController::class, 'index'])->name('paymentmethod');
Route::post('/paymentmethod/store', [PaymentMethodController::class, 'store'])->name('paymentmethod.store');

Route::get('/courier', [CourierController::class, 'index'])->name('courier');
Route::post('/courier/store', [CourierController::class, 'store'])->name('courier.store');

Route::get('/worktime', [WorkTimeController::class, 'index'])->name('worktime');
Route::post('/worktime/store', [WorkTimeController::class, 'store'])->name('worktime.store');


Route::post('/save-push-notification-token', [HomeController::class, 'savePushNotificationToken'])->name('save-push-notification-token');
Route::post('/send-push-notification', [HomeController::class, 'sendPushNotification'])->name('send.push-notification');

