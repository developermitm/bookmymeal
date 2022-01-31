<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppUserController;
use App\Http\Controllers\Admin\OffersController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\KitchenController;
use App\Http\Controllers\Admin\OrderScheduleController;
use App\Http\Controllers\Admin\ServiceLocationController;
use App\Http\Controllers\Admin\DeliveryBoyController;
use App\Http\Controllers\Admin\ProductAddonController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\BannerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RazorPayController;


Route::get('/', function () {

    return redirect('login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

	Route::group(
	[
		'prefix' => 'user',  //link url parameter
		'namespace' => 'User', //folder
		'middleware' => 'App\Http\Middleware\UserMiddleware'
	], function() {
		Route::match(['get', 'post'], '/', 'App\Http\Controllers\User\UserController@index');
		Route::get('/dashboard', [UserController::class, 'index'])->name('index');
	});

	Route::group(
	[
		'prefix' => 'admin',  //link url parameter
		//'namespace' => 'Admin', //folder
		'middleware' => 'App\Http\Middleware\AdminMiddleware'
	], function() {
		Route::match(['get', 'post'], '/', 'App\Http\Controllers\Admin\AdminController@index');
		
		Route::get('/dashboard', [AdminController::class, 'index'])->name('index');
		Route::get('/profile', [AdminController::class, 'updateProfile'])->name('profile');
		Route::get('/test', [AdminController::class, 'test'])->name('test');
		Route::get('/send-user-notification', [AdminController::class, 'sendNotification'])->name('send-user-notification');
		Route::post('/adminNotificationSend', [AdminController::class, 'adminNotificationSend'])->name('adminNotificationSend');
		Route::post('/profile', [AdminController::class, 'updateData'])->name('update-profile');
		Route::get('/user-listing', [AdminController::class, 'usersListing'])->name('user-listing');
		Route::get('/add-user', [AdminController::class, 'addUserForm'])->name('add-user');
		Route::post('/add-user', [AdminController::class, 'saveUserDetails'])->name('add-user');
		Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('edit-user');
		Route::post('/edit-user', [AdminController::class, 'updateUserDetails'])->name('edit-user');
		Route::get('/order-listing', [AdminController::class, 'orderListing'])->name('order-listing');
		Route::get('/send-notification', [NotificationController::class, 'sendOfferNotification']);
		Route::get('/activity-log', [AdminController::class, 'activityLog']);
		Route::get('/order-list', [OrderController::class, 'list']);
		Route::get('/pending-order-list', [OrderController::class, 'pendingList']);
		Route::get('/invoice/{id}', [OrderController::class, 'invoice']);
		Route::post('/edit-order-details', [OrderController::class, 'openEditOrderPopup']);
		Route::post('/update-order-details', [OrderController::class, 'updateOrderDetails']);
		Route::resource('addon', ProductAddonController::class);		
});	
		
		Route::resource('products', ProductsController::class);
		Route::get('products-list', [ProductsController::class, 'list']);
		Route::post('category-addon', [ProductsController::class, 'categoryAddon']);
		Route::post('products/store', [ProductsController::class, 'store']);
		Route::post('set-main-image', [ProductsController::class, 'setMainImage']);
		Route::get('upload-csv', [ProductsController::class, 'uploadCsv']);
		Route::post('upload-csv', [ProductsController::class, 'importCsvData']);
	
		Route::resource('appuser', AppUserController::class);
		Route::get('appuser-list', [AppUserController::class, 'list']);

		Route::resource('shipping', ShippingController::class);
		Route::get('shipping-list', [ShippingController::class, 'list']);

		Route::resource('kitchens', KitchenController::class);
		Route::get('kitchen-list', [KitchenController::class, 'list']);
		
		Route::resource('delivery-boy', DeliveryBoyController::class);
		Route::get('delivery-boy-list', [DeliveryBoyController::class, 'list']);
		Route::post('delete-deliveryBoy-doc', [DeliveryBoyController::class, 'deleteDeliveryBoyDoc']);
		
		Route::resource('order-schedule', OrderScheduleController::class);
		Route::get('order-schedule-list', [OrderScheduleController::class, 'list']);

		Route::resource('service-location', ServiceLocationController::class);
		Route::get('service-location-list', [ServiceLocationController::class, 'list']);

		Route::resource('banner', BannerController::class);
		Route::get('banner-list', [BannerController::class, 'list']);
		Route::post('banner/store', [BannerController::class, 'store']);

		Route::resource('offer', OffersController::class);
		Route::get('offer-list', [OffersController::class, 'list']);

		Route::resource('coupon', CouponController::class);
		Route::get('coupon-list', [CouponController::class, 'list']);
		
		Route::resource('category', CategoryController::class);
		Route::post('category/store', [CategoryController::class, 'store']);

		Route::get('category-list', [CategoryController::class, 'list']);
		
		Route::post('/create-order',[RazorPayController::class,'createOrder']);
	    Route::get('/verify-order',[RazorPayController::class,'verifyOrderForm']);
	    Route::post('/verify-order',[RazorPayController::class,'verifyOrder']);

